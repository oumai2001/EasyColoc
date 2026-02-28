<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'colocation_id',
        'user_id',
        'category_id',
        'title',
        'description',
        'amount',
        'expense_date',
        'split_type'
    ];

    protected $casts = [
        'expense_date' => 'date',
        'amount' => 'decimal:2'
    ];

    /**
     * Relations
     */
    public function colocation()
    {
        return $this->belongsTo(Colocation::class);
    }

    public function payer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function debtors()
    {
        return $this->belongsToMany(User::class)
                    ->withPivot('amount_owed', 'is_paid', 'paid_at')
                    ->withTimestamps();
    }
    public function isFullyPaid()
{
    return $this->debtors()->wherePivot('is_paid', false)->count() === 0;
}
}