<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('color')->default('#78350f'); // Couleur par défaut (marron)
            $table->string('icon')->nullable();
            $table->foreignId('colocation_id')->nullable()->constrained()->onDelete('cascade'); // NULL = catégorie globale
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->boolean('is_default')->default(false);
            $table->timestamps();
            
            // Une catégorie ne peut avoir le même nom dans une colocation
            $table->unique(['name', 'colocation_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};