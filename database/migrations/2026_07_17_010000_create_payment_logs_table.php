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
        Schema::create('payment_logs', function (Blueprint $table) {
            $table->id();
            $table->string('payable_type');
            $table->unsignedBigInteger('payable_id');
            $table->string('payment_method'); // Cash, bKash, Nagad, Rocket
            $table->decimal('amount', 10, 2);
            $table->string('transaction_type'); // initial, delivery, due_payment
            $table->timestamps();

            $table->index(['payable_type', 'payable_id']);
        });

        // Self-healing: Populate existing payments into payment_logs
        try {
            // Helper function to map old payment method "Card" to "bKash" as fallback
            $mapMethod = function ($method) {
                $method = trim($method);
                if (in_array($method, ['Cash', 'bKash', 'Nagad', 'Rocket'])) {
                    return $method;
                }
                if ($method === 'Card') {
                    return 'bKash'; // Fallback
                }
                return 'Cash'; // Safe default
            };

            // 1. Existing Sales Payments
            $sales = DB::table('sales')->get();
            foreach ($sales as $sale) {
                if (floatval($sale->paid_amount) > 0) {
                    DB::table('payment_logs')->insert([
                        'payable_type' => 'App\\Models\\Sale',
                        'payable_id' => $sale->id,
                        'payment_method' => $mapMethod($sale->payment_method),
                        'amount' => $sale->paid_amount,
                        'transaction_type' => 'initial',
                        'created_at' => $sale->created_at,
                        'updated_at' => $sale->updated_at,
                    ]);
                }
            }

            // 2. Existing Repairs Payments
            $repairs = DB::table('repairs')->get();
            foreach ($repairs as $repair) {
                $adv = floatval($repair->advance_payment);
                $paid = floatval($repair->paid_amount);

                // Advance payment log
                if ($adv > 0) {
                    DB::table('payment_logs')->insert([
                        'payable_type' => 'App\\Models\\Repair',
                        'payable_id' => $repair->id,
                        'payment_method' => $mapMethod($repair->advance_payment_method),
                        'amount' => $adv,
                        'transaction_type' => 'initial',
                        'created_at' => $repair->created_at,
                        'updated_at' => $repair->updated_at,
                    ]);
                }

                // Delivery payment log
                $delivery = $paid - $adv;
                if ($delivery > 0) {
                    DB::table('payment_logs')->insert([
                        'payable_type' => 'App\\Models\\Repair',
                        'payable_id' => $repair->id,
                        'payment_method' => $mapMethod($repair->payment_method),
                        'amount' => $delivery,
                        'transaction_type' => 'delivery',
                        'created_at' => $repair->completed_at ?? $repair->updated_at,
                        'updated_at' => $repair->completed_at ?? $repair->updated_at,
                    ]);
                }
            }
        } catch (\Exception $e) {
            Log::error("Failed to populate existing payment logs: " . $e->getMessage());
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_logs');
    }
};
