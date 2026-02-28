<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Invitation extends Model
{
    use HasFactory;

    protected $fillable = [
        'colocation_id',
        'inviter_id',
        'email',
        'token',
        'status',
        'expires_at',
        'accepted_at',
        'declined_at'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'accepted_at' => 'datetime',
        'declined_at' => 'datetime'
    ];

    /**
     * Générer un token unique avant la création
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($invitation) {
            $invitation->token = Str::random(60); // Token aléatoire
            $invitation->expires_at = now()->addDays(7); // Expire dans 7 jours
        });
    }

    /**
     * Relations
     */
    public function colocation()
    {
        return $this->belongsTo(Colocation::class);
    }

    public function inviter()
    {
        return $this->belongsTo(User::class, 'inviter_id');
    }

    /**
     * Vérifier si l'invitation est valide
     */
    public function isValid()
    {
        return $this->status === 'pending' 
            && $this->expires_at 
            && $this->expires_at->isFuture();
    }

    /**
     * Accepter l'invitation
     */
    public function accept()
    {
        $this->update([
            'status' => 'accepted',
            'accepted_at' => now()
        ]);
    }

    /**
     * Refuser l'invitation
     */
    public function decline()
    {
        $this->update([
            'status' => 'declined',
            'declined_at' => now()
        ]);
    }
}