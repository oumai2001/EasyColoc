<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\Invitation;
use App\Models\User;
use App\Mail\InvitationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class InvitationController extends Controller
{
    /**
     * Afficher les invitations en attente pour une colocation
     */
    public function index(Colocation $colocation)
    {
        // Vérifier que l'utilisateur est le propriétaire
        if (!$colocation->isOwner(Auth::user())) {
            return redirect()->route('colocations.show', $colocation)
                ->with('error', 'Seul le propriétaire peut gérer les invitations.');
        }

        $invitations = $colocation->invitations()
            ->where('status', 'pending')
            ->latest()
            ->get();

        return view('invitations.index', compact('colocation', 'invitations'));
    }

    /**
     * Envoyer une invitation
     */
    public function store(Request $request, Colocation $colocation)
    {
        // Vérifier que l'utilisateur est le propriétaire
        if (!$colocation->isOwner(Auth::user())) {
            return redirect()->route('colocations.show', $colocation)
                ->with('error', 'Seul le propriétaire peut inviter des membres.');
        }

        // Vérifier que la colocation est active
        if ($colocation->status !== 'active') {
            return redirect()->route('colocations.show', $colocation)
                ->with('error', 'Impossible d\'inviter dans une colocation inactive.');
        }

        $request->validate([
            'email' => 'required|email|max:255'
        ]);

        $email = $request->email;

        // Vérifier si l'utilisateur existe déjà et a une colocation active
        $existingUser = User::where('email', $email)->first();
        if ($existingUser && $existingUser->activeColocations()->count() > 0) {
            return redirect()->route('colocations.show', $colocation)
                ->with('error', 'Cet utilisateur a déjà une colocation active.');
        }

        // Vérifier si l'email est déjà membre de cette colocation
        if ($colocation->users()->where('email', $email)->exists()) {
            return redirect()->route('colocations.show', $colocation)
                ->with('error', 'Cet utilisateur est déjà membre de la colocation.');
        }

        // Vérifier s'il y a déjà une invitation en attente pour cet email
        $existingInvitation = $colocation->invitations()
            ->where('email', $email)
            ->where('status', 'pending')
            ->first();

        if ($existingInvitation) {
            return redirect()->route('colocations.show', $colocation)
                ->with('error', 'Une invitation est déjà en attente pour cet email.');
        }

        try {
            DB::transaction(function () use ($colocation, $email) {
                // Créer l'invitation
                $invitation = Invitation::create([
                    'colocation_id' => $colocation->id,
                    'inviter_id' => Auth::id(),
                    'email' => $email,
                    'status' => 'pending'
                ]);

                // Envoyer l'email
                Mail::to($email)->send(new InvitationMail($invitation));
            });

            return redirect()->route('colocations.show', $colocation)
                ->with('success', "Invitation envoyée à $email !");
        } catch (\Exception $e) {
            return redirect()->route('colocations.show', $colocation)
                ->with('error', "Erreur lors de l'envoi de l'invitation.");
        }
    }

    /**
     * Accepter une invitation
     */
    public function accept($token)
    {
        $invitation = Invitation::where('token', $token)->firstOrFail();

        // Vérifier si l'invitation est valide
        if (!$invitation->isValid()) {
            return redirect()->route('register')
                ->with('error', 'Cette invitation a expiré ou n\'est plus valide.');
        }

        // Si l'utilisateur n'est pas connecté, on le redirige vers login avec le token en session
        if (!Auth::check()) {
            session(['invitation_token' => $token]);
            return redirect()->route('login')
                ->with('info', 'Connectez-vous ou créez un compte pour accepter l\'invitation.');
        }

        $user = Auth::user();

        // Vérifier que l'email correspond à l'invitation
        if ($user->email !== $invitation->email) {
            return redirect()->route('dashboard')
                ->with('error', 'Cette invitation a été envoyée à une autre adresse email.');
        }

        // Vérifier que l'utilisateur n'a pas déjà une colocation active
        if ($user->activeColocations()->count() > 0) {
            return redirect()->route('dashboard')
                ->with('error', 'Vous avez déjà une colocation active. Vous ne pouvez pas en rejoindre une autre.');
        }

        DB::transaction(function () use ($invitation, $user) {
            // Ajouter l'utilisateur à la colocation
            $invitation->colocation->users()->attach($user->id, [
                'role' => 'member',
                'joined_at' => now()
            ]);

            // Marquer l'invitation comme acceptée
            $invitation->accept();
        });

        return redirect()->route('colocations.show', $invitation->colocation)
            ->with('success', 'Félicitations ! Vous avez rejoint la colocation !');
    }

    /**
     * Refuser une invitation
     */
    public function decline($token)
    {
        $invitation = Invitation::where('token', $token)->firstOrFail();

        if ($invitation->isValid()) {
            $invitation->decline();
        }

        return redirect()->route('dashboard')
            ->with('info', 'Vous avez refusé l\'invitation.');
    }

    /**
     * Annuler une invitation (supprimer)
     */
    public function destroy(Invitation $invitation)
    {
        // Vérifier que l'utilisateur est le propriétaire de la colocation
        if ($invitation->colocation->owner_id !== Auth::id()) {
            return redirect()->route('colocations.show', $invitation->colocation)
                ->with('error', 'Vous n\'êtes pas autorisé à annuler cette invitation.');
        }

        $invitation->delete();

        return redirect()->route('colocations.show', $invitation->colocation)
            ->with('success', 'Invitation annulée.');
    }
}