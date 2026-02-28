<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\Expense;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Afficher le formulaire de création
     */
    public function create(Colocation $colocation)
    {
        // Vérifier que l'utilisateur est membre actuel
        if (!$colocation->hasActiveMember(Auth::user())) {
            return redirect()->route('colocations.index')
                ->with('error', 'Vous n\'êtes pas membre de cette colocation.');
        }

        $categories = Category::all();
        $members = $colocation->activeUsers()->get();

        return view('expenses.create', compact('colocation', 'categories', 'members'));
    }

    /**
     * Enregistrer une nouvelle dépense
     */
    public function store(Request $request, Colocation $colocation)
    {
        // Vérifier que l'utilisateur est membre actuel
        if (!$colocation->hasActiveMember(Auth::user())) {
            return redirect()->route('colocations.index')
                ->with('error', 'Vous n\'êtes pas membre de cette colocation.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'category_id' => 'required|exists:categories,id',
            'expense_date' => 'required|date',
            'description' => 'nullable|string',
            'split_type' => 'required|in:equal,custom',
            'debtors' => 'required_if:split_type,custom|array',
            'debtors.*' => 'exists:users,id',
            'amounts' => 'required_if:split_type,custom|array',
            'amounts.*' => 'numeric|min:0'
        ]);

        $activeMembers = $colocation->activeUsers()->pluck('users.id')->toArray();

        DB::transaction(function () use ($request, $colocation) {
            // Créer la dépense
            $expense = Expense::create([
                'colocation_id' => $colocation->id,
                'user_id' => Auth::id(),
                'category_id' => $request->category_id,
                'title' => $request->title,
                'description' => $request->description,
                'amount' => $request->amount,
                'expense_date' => $request->expense_date,
                'split_type' => $request->split_type
            ]);

            // Gérer les débiteurs
            if ($request->split_type === 'equal') {
                // Partage égal entre tous les membres actifs
                $members = $colocation->activeUsers()->get();
                $sharePerPerson = round($request->amount / $members->count(), 2);
                
                foreach ($members as $member) {
                    // Le payeur ne se doit rien à lui-même
                    if ($member->id !== Auth::id()) {
                        $expense->debtors()->attach($member->id, [
                            'amount_owed' => $sharePerPerson,
                            'is_paid' => false
                        ]);
                    }
                }
            } else {
                // Partage personnalisé
                foreach ($request->debtors as $index => $debtorId) {
                    // Ignorer si le montant est 0 ou si c'est le payeur
                    if ($debtorId != Auth::id() && $request->amounts[$index] > 0) {
                        $expense->debtors()->attach($debtorId, [
                            'amount_owed' => $request->amounts[$index],
                            'is_paid' => false
                        ]);
                    }
                }
            }
        });

        return redirect()->route('colocations.show', $colocation)
            ->with('success', 'Dépense ajoutée avec succès !');
    }

    /**
     * Afficher les détails d'une dépense
     */
    public function show(Colocation $colocation, Expense $expense)
    {
        // Vérifier que la dépense appartient bien à cette colocation
        if ($expense->colocation_id !== $colocation->id) {
            abort(404);
        }

        // Vérifier que l'utilisateur est membre actuel
        if (!$colocation->hasActiveMember(Auth::user())) {
            return redirect()->route('colocations.index')
                ->with('error', 'Vous n\'êtes pas membre de cette colocation.');
        }

        $expense->load(['payer', 'category', 'debtors']);

        return view('expenses.show', compact('colocation', 'expense'));
    }

    /**
     * Marquer une part comme payée
     */
public function markAsPaid(Colocation $colocation, Expense $expense, User $debtor)
{
    // Vérifier que la dépense appartient à la colocation
    if ($expense->colocation_id !== $colocation->id) {
        abort(404);
    }

    // Vérifier que l'utilisateur est le payeur ou le débiteur
    $user = Auth::user();
    if ($user->id !== $expense->user_id && $user->id !== $debtor->id) {
        return redirect()->route('colocations.show', $colocation)
            ->with('error', 'Vous n\'êtes pas autorisé à effectuer cette action.');
    }

    DB::transaction(function () use ($expense, $debtor, $colocation, $user) {
        // Mettre à jour le statut de paiement
        $expense->debtors()->updateExistingPivot($debtor->id, [
            'is_paid' => true,
            'paid_at' => now()
        ]);

        // Créer un enregistrement de paiement
        Payment::create([
            'colocation_id' => $colocation->id,
            'from_user_id' => $debtor->id,
            'to_user_id' => $expense->user_id,
            'amount' => $expense->debtors()->find($debtor->id)->pivot->amount_owed,
            'description' => "Remboursement pour : {$expense->title}",
            'status' => 'completed',
            'paid_at' => now()
        ]);

        // Bonus de réputation pour celui qui rembourse (si c'est lui qui marque)
        if ($user->id === $debtor->id) {
            $debtor->increaseReputation(1); // +1 pour remboursement volontaire
        }
    });

    return redirect()->route('expenses.show', [$colocation, $expense])
        ->with('success', 'Paiement enregistré !');
}

// Nouvelle méthode pour marquer un remboursement direct (sans dépense spécifique)
public function markSettlement(Request $request, Colocation $colocation)
{
    $request->validate([
        'from_user_id' => 'required|exists:users,id',
        'to_user_id' => 'required|exists:users,id',
        'amount' => 'required|numeric|min:0.01',
        'description' => 'nullable|string'
    ]);

    $fromUser = User::find($request->from_user_id);
    $toUser = User::find($request->to_user_id);

    // Vérifier que les deux sont membres actifs
    if (!$colocation->hasActiveMember($fromUser) || !$colocation->hasActiveMember($toUser)) {
        return redirect()->route('colocations.show', $colocation)
            ->with('error', 'Les deux utilisateurs doivent être membres actifs.');
    }

    // Vérifier que l'utilisateur connecté est impliqué
    $user = Auth::user();
    if ($user->id !== $fromUser->id && $user->id !== $toUser->id) {
        return redirect()->route('colocations.show', $colocation)
            ->with('error', 'Vous ne pouvez marquer qu\'un paiement qui vous concerne.');
    }

    DB::transaction(function () use ($request, $colocation, $fromUser, $toUser) {
        // Créer le paiement
        Payment::create([
            'colocation_id' => $colocation->id,
            'from_user_id' => $fromUser->id,
            'to_user_id' => $toUser->id,
            'amount' => $request->amount,
            'description' => $request->description ?? 'Remboursement',
            'status' => 'completed',
            'paid_at' => now()
        ]);

        // Bonus de réputation pour celui qui rembourse
        if (Auth::id() === $fromUser->id) {
            $fromUser->increaseReputation(1);
        }
    });

    return redirect()->route('colocations.show', $colocation)
        ->with('success', 'Paiement enregistré avec succès !');
}

    /**
     * Supprimer une dépense
     */
    public function destroy(Colocation $colocation, Expense $expense)
    {
        // Vérifier que la dépense appartient à la colocation
        if ($expense->colocation_id !== $colocation->id) {
            abort(404);
        }

        // Seul le payeur ou le propriétaire peut supprimer
        if ($expense->user_id !== Auth::id() && !$colocation->isOwner(Auth::user())) {
            return redirect()->route('colocations.show', $colocation)
                ->with('error', 'Vous n\'êtes pas autorisé à supprimer cette dépense.');
        }

        $expense->delete();

        return redirect()->route('colocations.show', $colocation)
            ->with('success', 'Dépense supprimée.');
    }

    /**
     * Calculer les soldes pour une colocation
     */
    public static function calculateBalances(Colocation $colocation)
    {
        $members = $colocation->activeUsers()->get();
        $balances = [];

        // Initialiser les soldes à 0
        foreach ($members as $member) {
            $balances[$member->id] = [
                'user' => $member,
                'paid' => 0,      // Total payé par cette personne
                'owed' => 0,       // Total que cette personne doit
                'balance' => 0     // Solde final (positif = à recevoir, négatif = à donner)
            ];
        }

        // Récupérer toutes les dépenses de la colocation
        $expenses = $colocation->expenses()->with('debtors')->get();

        foreach ($expenses as $expense) {
            // Ce que le payeur a payé
            if (isset($balances[$expense->user_id])) {
                $balances[$expense->user_id]['paid'] += $expense->amount;
            }

            // Ce que chacun doit
            foreach ($expense->debtors as $debtor) {
                if (isset($balances[$debtor->id])) {
                    $balances[$debtor->id]['owed'] += $debtor->pivot->amount_owed;
                }
            }
        }

        // Calculer le solde final
        foreach ($balances as $userId => &$balance) {
            $balance['balance'] = $balance['paid'] - $balance['owed'];
        }

        return $balances;
    }

    /**
     * Calculer les remboursements simplifiés (qui doit à qui)
     */
    public static function calculateSettlements(Colocation $colocation)
    {
        $balances = self::calculateBalances($colocation);
        
        // Séparer ceux qui doivent et ceux qui reçoivent
        $debtors = [];
        $creditors = [];

        foreach ($balances as $userId => $balance) {
            if ($balance['balance'] < 0) {
                // Cette personne doit de l'argent (balance négative)
                $debtors[] = [
                    'user' => $balance['user'],
                    'amount' => abs($balance['balance'])
                ];
            } elseif ($balance['balance'] > 0) {
                // Cette personne reçoit de l'argent (balance positive)
                $creditors[] = [
                    'user' => $balance['user'],
                    'amount' => $balance['balance']
                ];
            }
        }

        // Trier par montant (du plus grand au plus petit)
        usort($debtors, fn($a, $b) => $b['amount'] <=> $a['amount']);
        usort($creditors, fn($a, $b) => $b['amount'] <=> $a['amount']);

        $settlements = [];

        // Algorithme glouton pour minimiser les transactions
        while (!empty($debtors) && !empty($creditors)) {
            $debtor = $debtors[0];
            $creditor = $creditors[0];

            $amount = min($debtor['amount'], $creditor['amount']);

            $settlements[] = [
                'from' => $debtor['user'],
                'to' => $creditor['user'],
                'amount' => round($amount, 2)
            ];

            // Mettre à jour les montants
            if ($debtor['amount'] > $amount) {
                $debtors[0]['amount'] -= $amount;
            } else {
                array_shift($debtors);
            }

            if ($creditor['amount'] > $amount) {
                $creditors[0]['amount'] -= $amount;
            } else {
                array_shift($creditors);
            }
        }

        return $settlements;
    }
}