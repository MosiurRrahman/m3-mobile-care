<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->decimal('paid_amount', 10, 2)->default(0.00)->after('payable_amount');
            $table->decimal('due_amount', 10, 2)->default(0.00)->after('paid_amount');
            $table->decimal('cash_received', 10, 2)->default(0.00)->after('due_amount');
            $table->decimal('change_returned', 10, 2)->default(0.00)->after('cash_received');
        });

        // Populate existing sales
        DB::table('sales')->update([
            'paid_amount' => DB::raw('payable_amount'),
            'due_amount' => 0.00,
            'cash_received' => DB::raw('payable_amount'),
            'change_returned' => 0.00
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn(['paid_amount', 'due_amount', 'cash_received', 'change_returned']);
        });
    }
};
