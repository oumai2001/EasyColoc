<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 use App\Models\Membership;
class Colocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
        'owner_id'
    ];

    protected $casts = [
        'status' => 'string'
    ];

    /**
     * Relations
     */
    
    // Le propriétaire de la colocation
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    // Tous les membres (actuels et passés)


public function users()
{
    return $this->belongsToMany(User::class)
        ->using(Membership::class)
        ->withPivot('role', 'joined_at', 'left_at')
        ->withTimestamps();
}
    // Membres ACTUELS seulement
public function activeUsers()
{
    return $this->belongsToMany(User::class)
        ->using(Membership::class)
        ->wherePivotNull('left_at')
        ->withPivot('role', 'joined_at', 'left_at')
        ->withTimestamps();
}
/**
 * Relation avec les dépenses
 */
public function expenses()
{
    return $this->hasMany(Expense::class);
}

    // Vérifier si un user est membre actuel
    public function hasActiveMember(User $user)
    {
        return $this->activeUsers()->where('user_id', $user->id)->exists();
    }

    // Vérifier si un user est le owner
    public function isOwner(User $user)
    {
        return $this->owner_id === $user->id;
    }
    // Dans la classe Colocation, après les autres relations
public function invitations()
{
    return $this->hasMany(Invitation::class);
}
/**
 * Vérifier si un membre a des dettes avant de partir
 */
public function memberHasDebts(User $user)
{
    return $user->hasDebtsInColocation($this);
}

/**
 * Transférer les dettes d'un membre à l'owner (quand un membre est retiré avec dette)
 */
public function transferDebtsToOwner(User $leavingUser)
{
    $owner = $this->owner;
    
    // Récupérer toutes les dettes non payées de l'utilisateur qui part
    $debts = DB::table('expense_user')
        ->join('expenses', 'expenses.id', '=', 'expense_user.expense_id')
        ->where('expenses.colocation_id', $this->id)
        ->where('expense_user.user_id', $leavingUser->id)
        ->where('expense_user.is_paid', false)
        ->get();

    foreach ($debts as $debt) {
        // Transférer la dette à l'owner
        DB::table('expense_user')
            ->where('id', $debt->id)
            ->update([
                'user_id' => $owner->id,
                'updated_at' => now()
            ]);
    }
}
}