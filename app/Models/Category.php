<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'color',
        'icon',
        'colocation_id',
        'created_by',
        'is_default'
    ];

    protected $casts = [
        'is_default' => 'boolean'
    ];

    /**
     * Relations
     */
    public function colocation()
    {
        return $this->belongsTo(Colocation::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    /**
     * Scope pour récupérer les catégories disponibles pour une colocation
     */
    public function scopeForColocation($query, $colocationId)
    {
        return $query->where(function($q) use ($colocationId) {
            $q->whereNull('colocation_id') // Catégories globales
              ->orWhere('colocation_id', $colocationId); // Catégories spécifiques à la coloc
        });
    }
}