<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Adds:
     *  - repairs.completed_at  : Timestamp when repair was marked completed/delivered.
     *                            Used for accurate financial date filtering instead of updated_at,
     *                            which changes on any record edit.
     *  - sales_details.purchase_price : Snapshot of inventory purchase price at time of sale
     *                                   for accurate historical COGS calculations.
     */
    public function up(): void
    {
        // Add completed_at to repairs table
        Schema::table('repairs', function (Blueprint $table) {
            $table->timestamp('completed_at')->nullable()->after('updated_at');
        });

        // Add purchase_price snapshot to sales_details table
        Schema::table('sales_details', function (Blueprint $table) {
            $table->decimal('purchase_price', 10, 2)->default(0.00)->after('sale_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('repairs', function (Blueprint $table) {
            $table->dropColumn('completed_at');
        });

        Schema::table('sales_details', function (Blueprint $table) {
            $table->dropColumn('purchase_price');
        });
    }
};
