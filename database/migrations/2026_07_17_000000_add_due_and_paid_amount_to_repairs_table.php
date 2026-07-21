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
        Schema::table('repairs', function (Blueprint $table) {
            $table->decimal('paid_amount', 10, 2)->default(0.00)->after('actual_cost');
            $table->decimal('due_amount', 10, 2)->default(0.00)->after('paid_amount');
        });

        // Self-healing / initialize existing records
        try {
            // Completed/delivered repairs are assumed fully paid by default (paid = actual_cost)
            DB::table('repairs')
                ->whereIn('status', ['completed', 'delivered'])
                ->update([
                    'paid_amount' => DB::raw('COALESCE(actual_cost, estimated_cost, 0.00)'),
                    'due_amount' => 0.00
                ]);

            // Other states (pending, diagnosing, repairing etc.) have paid_amount = advance_payment
            DB::table('repairs')
                ->whereNotIn('status', ['completed', 'delivered'])
                ->update([
                    'paid_amount' => DB::raw('COALESCE(advance_payment, 0.00)'),
                    'due_amount' => 0.00
                ]);
        } catch (\Exception $e) {
            // Fail-safe if DB is empty or table layout is different
            Log::error("Failed to initialize repairs paid/due amount: " . $e->getMessage());
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('repairs', function (Blueprint $table) {
            $table->dropColumn(['paid_amount', 'due_amount']);
        });
    }
};
