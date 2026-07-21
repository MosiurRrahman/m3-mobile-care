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
        if (!Schema::hasColumn('inventory_items', 'min_sale_price')) {
            Schema::table('inventory_items', function (Blueprint $table) {
                $table->decimal('min_sale_price', 10, 2)->nullable()->after('sale_price');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('inventory_items', 'min_sale_price')) {
            Schema::table('inventory_items', function (Blueprint $table) {
                $table->dropColumn('min_sale_price');
            });
        }
    }
};
