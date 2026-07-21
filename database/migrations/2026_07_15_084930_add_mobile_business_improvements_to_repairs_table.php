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
        Schema::table('repairs', function (Blueprint $table) {
            $table->boolean('is_stock_deducted')->default(false)->after('status');
            $table->text('pattern_lock_path')->nullable()->after('password_pattern');
            $table->boolean('data_loss_consent')->default(false)->after('pattern_lock_path');
            $table->integer('warranty_days')->default(0)->after('actual_cost');
            $table->date('warranty_expiry_date')->nullable()->after('warranty_days');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('repairs', function (Blueprint $table) {
            $table->dropColumn([
                'is_stock_deducted',
                'pattern_lock_path',
                'data_loss_consent',
                'warranty_days',
                'warranty_expiry_date'
            ]);
        });
    }
};
