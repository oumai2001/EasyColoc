<?php

namespace App\Models;

<<<<<<< HEAD
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Membership;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

=======
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
>>>>>>> 8e94925080aafa664147f8b1fd6ee70babb48e2c
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

<<<<<<< HEAD
=======
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
>>>>>>> 8e94925080aafa664147f8b1fd6ee70babb48e2c
    protected $hidden = [
        'password',
        'remember_token',
    ];

<<<<<<< HEAD
=======
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
>>>>>>> 8e94925080aafa664147f8b1fd6ee70babb48e2c
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
<<<<<<< HEAD

    /**
     * Relations
     */
    
    // Colocations dont l'utilisateur est propriétaire (via la clé owner_id)
    public function ownedColocations()
    {
        return $this->hasMany(Colocation::class, 'owner_id');
    }

    // Toutes les colocations de l'utilisateur (actuelles et passées)
   public function colocations()
{
    return $this->belongsToMany(Colocation::class)
        ->using(Membership::class)
        ->withPivot('role', 'joined_at', 'left_at')
        ->withTimestamps();
}

    // Colocations ACTUELLES seulement
    public function activeColocations()
    {
        return $this->belongsToMany(Colocation::class)
                    ->wherePivotNull('left_at')  // left_at IS NULL => membre actuel
                    ->withPivot('role', 'joined_at')
                    ->withTimestamps();
    }
    /**
 * Améliorer la réputation
 */
public function increaseReputation($points = 1)
{
    $this->increment('reputation', $points);
}

/**
 * Diminuer la réputation
 */
public function decreaseReputation($points = 1)
{
    $this->decrement('reputation', $points);
}

/**
 * Vérifier si l'utilisateur a des dettes dans une colocation
 */
public function hasDebtsInColocation(Colocation $colocation)
{
    // Récupérer toutes les dépenses où cet utilisateur doit de l'argent
    $totalOwed = $colocation->expenses()
        ->whereHas('debtors', function($query) {
            $query->where('user_id', $this->id)
                  ->where('is_paid', false);
        })
        ->join('expense_user', 'expenses.id', '=', 'expense_user.expense_id')
        ->where('expense_user.user_id', $this->id)
        ->where('expense_user.is_paid', false)
        ->sum('expense_user.amount_owed');

    return $totalOwed > 0;
}

/**
 * Obtenir le total des dettes dans une colocation
 */
public function getTotalDebtInColocation(Colocation $colocation)
{
    return $colocation->expenses()
        ->whereHas('debtors', function($query) {
            $query->where('user_id', $this->id)
                  ->where('is_paid', false);
        })
        ->join('expense_user', 'expenses.id', '=', 'expense_user.expense_id')
        ->where('expense_user.user_id', $this->id)
        ->where('expense_user.is_paid', false)
        ->sum('expense_user.amount_owed');
}
}
=======
}
>>>>>>> 8e94925080aafa664147f8b1fd6ee70babb48e2c
