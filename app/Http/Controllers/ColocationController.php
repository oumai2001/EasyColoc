<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ColocationController extends Controller
{


    /**
     * Afficher la liste des colocations de l'utilisateur
     */
    public function index()
    {
        $user = Auth::user();
        
        // Récupérer les colocations actives de l'utilisateur
        $activeColocations = $user->activeColocations;
        
        // Récupérer l'historique des colocations (où left_at n'est pas null)
        $historyColocations = $user->colocations()
            ->wherePivotNotNull('left_at')
            ->get();

        return view('colocations.index', compact('activeColocations', 'historyColocations'));
    }

    /**
     * Formulaire de création d'une colocation
     */
    public function create()
    {
        // Vérifier si l'utilisateur a déjà une colocation active
        if (Auth::user()->activeColocations()->count() > 0) {
            return redirect()->route('colocations.index')
                ->with('error', 'Vous avez déjà une colocation active. Vous ne pouvez en créer qu\'une seule à la fois.');
        }

        return view('colocations.create');
    }

    /**
     * Enregistrer une nouvelle colocation
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $user = Auth::user();

        // Vérification : un seul colocation active par utilisateur
        if ($user->activeColocations()->count() > 0) {
            return redirect()->route('colocations.index')
                ->with('error', 'Vous ne pouvez créer qu\'une seule colocation à la fois.');
        }

        DB::transaction(function () use ($request, $user) {
            // Créer la colocation
            $colocation = Colocation::create([
                'name' => $request->name,
                'owner_id' => $user->id,
                'status' => 'active'
            ]);

            // Ajouter le créateur comme membre avec rôle owner
            $colocation->users()->attach($user->id, [
                'role' => 'owner',
                'joined_at' => now()
            ]);
        });

        return redirect()->route('colocations.index')
            ->with('success', 'Colocation créée avec succès !');
    }

    /**
     * Afficher une colocation spécifique
     */
    public function show(Colocation $colocation)
{
    // Vérifier que l'utilisateur est membre actuel de cette colocation
    if (!$colocation->hasActiveMember(Auth::user())) {
        return redirect()->route('colocations.index')
            ->with('error', 'Vous n\'êtes pas membre de cette colocation.');
    }

    // Charger les membres actifs
    $members = $colocation->activeUsers()->get();
    
    // Charger les dépenses
    $expenses = $colocation->expenses()->with(['payer', 'category'])->latest('expense_date')->get();
    
    return view('colocations.show', compact('colocation', 'members', 'expenses'));
}

    /**
     * Formulaire d'édition
     */
    public function edit(Colocation $colocation)
    {
        // Vérifier que l'utilisateur est le propriétaire
        if (!$colocation->isOwner(Auth::user())) {
            return redirect()->route('colocations.index')
                ->with('error', 'Seul le propriétaire peut modifier la colocation.');
        }

        return view('colocations.edit', compact('colocation'));
    }

    /**
     * Mettre à jour la colocation
     */
    public function update(Request $request, Colocation $colocation)
    {
        // Vérifier que l'utilisateur est le propriétaire
        if (!$colocation->isOwner(Auth::user())) {
            return redirect()->route('colocations.index')
                ->with('error', 'Seul le propriétaire peut modifier la colocation.');
        }

        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $colocation->update([
            'name' => $request->name
        ]);

        return redirect()->route('colocations.show', $colocation)
            ->with('success', 'Colocation mise à jour avec succès.');
    }

    /**
     * Quitter une colocation (pour les membres)
     */
    /**
 * Quitter une colocation (pour les membres)
 */
public function leave(Request $request, Colocation $colocation)
{
    $user = Auth::user();

    // Vérifier que l'utilisateur est membre actuel
    if (!$colocation->hasActiveMember($user)) {
        return redirect()->route('colocations.index')
            ->with('error', 'Vous n\'êtes pas membre de cette colocation.');
    }

    // Empêcher le propriétaire de quitter (il doit annuler la coloc)
    if ($colocation->isOwner($user)) {
        return redirect()->route('colocations.show', $colocation)
            ->with('error', 'En tant que propriétaire, vous devez annuler la colocation plutôt que la quitter.');
    }

    DB::transaction(function () use ($colocation, $user) {
        // Vérifier si l'utilisateur a des dettes
        $hasDebts = $colocation->memberHasDebts($user);
        
        // Mettre à jour left_at dans la table pivot
        $colocation->users()->updateExistingPivot($user->id, [
            'left_at' => now()
        ]);
        
        // Gérer la réputation
        if ($hasDebts) {
            // Départ avec dette => pénalité
            $user->decreaseReputation(1);
            
            // Notification (optionnelle)
            session()->flash('info', 'Vous avez quitté avec des dettes. Votre réputation a baissé.');
        } else {
            // Départ sans dette => bonus
            $user->increaseReputation(1);
            session()->flash('success', 'Vous avez quitté la colocation en règle. +1 de réputation !');
        }
    });

    return redirect()->route('colocations.index');
}

/**
 * Annuler une colocation (pour le propriétaire)
 */public function cancel(Request $request, Colocation $colocation)
{
    if (!$colocation->isOwner(Auth::user())) {
        return redirect()->route('colocations.index')
            ->with('error', 'Seul le propriétaire peut annuler la colocation.');
    }

    DB::transaction(function () use ($colocation) {
        $owner = $colocation->owner;

        // Tous les membres actifs sauf owner
        $members = $colocation->users->filter(function($user) use ($colocation) {
            return $user->id !== $colocation->owner_id && $user->pivot->left_at === null;
        });

        foreach ($members as $member) {
            $hasDebts = $colocation->memberHasDebts($member);

            if ($hasDebts) {
                $member->decreaseReputation(1);
                $colocation->transferDebtsToOwner($member);
            } else {
                $member->increaseReputation(1);
            }
        }

        $colocation->update(['status' => 'cancelled']);

        // Marquer tous les membres comme quittés
        foreach ($colocation->users as $user) {
            if ($user->pivot->left_at === null) {
                $colocation->users()->updateExistingPivot($user->id, [
                    'left_at' => now()
                ]);
            }
        }

        $owner->increaseReputation(1);
    });

    return redirect()->route('colocations.index')
        ->with('success', 'Colocation annulée avec succès.');
}

/**
 * Retirer un membre (pour l'owner seulement)
 */
public function removeMember(Request $request, Colocation $colocation, User $member)
{
    // Vérifier que l'utilisateur est le propriétaire
    if (!$colocation->isOwner(Auth::user())) {
        return redirect()->route('colocations.show', $colocation)
            ->with('error', 'Seul le propriétaire peut retirer des membres.');
    }

    // Empêcher de retirer soi-même
    if ($member->id === Auth::id()) {
        return redirect()->route('colocations.show', $colocation)
            ->with('error', 'Vous ne pouvez pas vous retirer vous-même. Utilisez "Annuler la colocation".');
    }

    // Vérifier que le membre est actif
    if (!$colocation->hasActiveMember($member)) {
        return redirect()->route('colocations.show', $colocation)
            ->with('error', 'Cet utilisateur n\'est pas membre actif.');
    }

    DB::transaction(function () use ($colocation, $member) {
        $hasDebts = $colocation->memberHasDebts($member);
        
        if ($hasDebts) {
            // Si le membre a des dettes, elles sont transférées à l'owner
            $colocation->transferDebtsToOwner($member);
            
            // Pénalité pour le membre
            $member->decreaseReputation(2); // Pénalité plus sévère car retiré pour dette
            
            session()->flash('info', 'Le membre avait des dettes. Elles ont été transférées à votre compte.');
        } else {
            // Pas de dette, bonus pour le membre
            $member->increaseReputation(1);
        }
        
        // Marquer comme ayant quitté
        $colocation->users()->updateExistingPivot($member->id, [
            'left_at' => now()
        ]);
    });

    return redirect()->route('colocations.show', $colocation)
        ->with('success', "{$member->name} a été retiré de la colocation.");
}

    /**
     * Supprimer définitivement (admin seulement plus tard)
     */
    public function destroy(Colocation $colocation)
    {
        // TODO: Seulement pour admin
        $colocation->delete();
        
        return redirect()->route('colocations.index')
            ->with('success', 'Colocation supprimée définitivement.');
    }
    /**
 * Afficher la page de confirmation d'annulation
 */
public function confirmCancel(Colocation $colocation)
{
    // Vérifier que l'utilisateur est le propriétaire
    if (!$colocation->isOwner(Auth::user())) {
        return redirect()->route('colocations.index')
            ->with('error', 'Seul le propriétaire peut annuler la colocation.');
    }

    // Vérifier que la colocation est active
    if ($colocation->status !== 'active') {
        return redirect()->route('colocations.show', $colocation)
            ->with('error', 'Cette colocation est déjà annulée.');
    }

    // Calculer quelques statistiques pour la page de confirmation
    $membersCount = $colocation->activeUsers()->count();
    $expensesCount = $colocation->expenses()->count();
    $totalSpent = $colocation->expenses()->sum('amount');
    
    // Vérifier s'il y a des dettes non réglées
    $hasPendingDebts = false;
    foreach ($colocation->activeUsers as $member) {
        if ($member->hasDebtsInColocation($colocation)) {
            $hasPendingDebts = true;
            break;
        }
    }

    return view('colocations.confirm-cancel', compact(
        'colocation', 
        'membersCount', 
        'expensesCount', 
        'totalSpent',
        'hasPendingDebts'
    ));
}
}