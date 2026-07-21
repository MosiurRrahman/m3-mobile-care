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
        // 1. Partner Balances
        Schema::create('partner_balances', function (Blueprint $table) {
            $table->id();
            $table->string('partner_name')->unique();
            $table->decimal('capital_balance', 15, 2)->default(0.00);
            $table->decimal('accumulated_profit', 15, 2)->default(0.00);
            $table->timestamp('payback_completed_at')->nullable();
            $table->timestamps();
        });

        // 2. Partner Ledger Entries
        Schema::create('partner_ledger_entries', function (Blueprint $table) {
            $table->id();
            $table->string('partner_name');
            $table->string('account_type'); // capital, profit
            $table->string('type'); // credit, debit
            $table->decimal('amount', 15, 2);
            $table->decimal('balance_after', 15, 2);
            $table->string('month', 7)->nullable(); // YYYY-MM
            $table->string('description', 1000)->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();

            $table->index(['partner_name', 'account_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partner_ledger_entries');
        Schema::dropIfExists('partner_balances');
    }
};
