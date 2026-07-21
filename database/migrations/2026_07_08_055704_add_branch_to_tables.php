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
            $table->string('branch')->nullable()->after('assigned_technician_id');
        });

        Schema::table('inventory_items', function (Blueprint $table) {
            $table->string('branch')->nullable()->after('sale_price');
        });

        Schema::table('sales', function (Blueprint $table) {
            $table->string('branch')->nullable()->after('salesman_id');
        });

        Schema::table('purchases', function (Blueprint $table) {
            $table->string('branch')->nullable()->after('supplier_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('repairs', function (Blueprint $table) {
            $table->dropColumn('branch');
        });

        Schema::table('inventory_items', function (Blueprint $table) {
            $table->dropColumn('branch');
        });

        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn('branch');
        });

        Schema::table('purchases', function (Blueprint $table) {
            $table->dropColumn('branch');
        });
    }
};
