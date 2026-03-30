<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('expense_user', function (Blueprint $table) {
            if (!Schema::hasColumn('expense_user', 'paid_at')) {
                $table->timestamp('paid_at')->nullable()->after('is_paid');
            }
        });
    }

    public function down(): void
    {
        Schema::table('expense_user', function (Blueprint $table) {
            $table->dropColumn('paid_at');
        });
    }
};