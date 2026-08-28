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
            $table->index('status');
            $table->index('created_at');
            $table->index('completed_at');
            $table->index('branch');
        });

        Schema::table('sales', function (Blueprint $table) {
            $table->index('created_at');
        });

        Schema::table('activity_logs', function (Blueprint $table) {
            $table->index('created_at');
        });

        Schema::table('payment_logs', function (Blueprint $table) {
            $table->index('payment_method');
            $table->index('created_at');
        });

        Schema::table('expenses', function (Blueprint $table) {
            $table->index('expense_date');
            $table->index('category');
            $table->index('register_type');
        });

        Schema::table('special_orders', function (Blueprint $table) {
            $table->index('status');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('repairs', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['created_at']);
            $table->dropIndex(['completed_at']);
            $table->dropIndex(['branch']);
        });

        Schema::table('sales', function (Blueprint $table) {
            $table->dropIndex(['created_at']);
        });

        Schema::table('activity_logs', function (Blueprint $table) {
            $table->dropIndex(['created_at']);
        });

        Schema::table('payment_logs', function (Blueprint $table) {
            $table->dropIndex(['payment_method']);
            $table->dropIndex(['created_at']);
        });

        Schema::table('expenses', function (Blueprint $table) {
            $table->dropIndex(['expense_date']);
            $table->dropIndex(['category']);
            $table->dropIndex(['register_type']);
        });

        Schema::table('special_orders', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['created_at']);
        });
    }
};
