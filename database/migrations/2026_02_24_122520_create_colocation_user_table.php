<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('colocation_user', function (Blueprint $table) {
        $table->id();
        $table->foreignId('colocation_id')->constrained()->onDelete('cascade');
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->enum('role', ['owner', 'member'])->default('member'); // Rôle dans cette coloc
        $table->timestamp('joined_at')->useCurrent(); // Date d'arrivée
        $table->timestamp('left_at')->nullable(); // Date de départ (si null => toujours actif)
        $table->unique(['colocation_id', 'user_id', 'left_at']); // Éviter les doublons
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('colocation_user');
    }
};
