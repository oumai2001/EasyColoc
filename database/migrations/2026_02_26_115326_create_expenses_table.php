<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('colocation_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Celui qui a payé
            $table->foreignId('category_id')->constrained();
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('amount', 10, 2); // Montant total
            $table->date('expense_date');
            $table->enum('split_type', ['equal', 'custom'])->default('equal'); // Type de partage
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};