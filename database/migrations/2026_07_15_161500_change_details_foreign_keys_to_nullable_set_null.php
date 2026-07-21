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
        // 1. sales_details table
        Schema::table('sales_details', function (Blueprint $table) {
            // Drop old foreign key
            $table->dropForeign(['inventory_item_id']);
            
            // Make column nullable
            $table->unsignedBigInteger('inventory_item_id')->nullable()->change();
            
            // Re-create foreign key with onDelete('set null')
            $table->foreign('inventory_item_id')
                ->references('id')
                ->on('inventory_items')
                ->onDelete('set null');
        });

        // 2. purchase_details table
        Schema::table('purchase_details', function (Blueprint $table) {
            // Drop old foreign key
            $table->dropForeign(['inventory_item_id']);
            
            // Make column nullable
            $table->unsignedBigInteger('inventory_item_id')->nullable()->change();
            
            // Re-create foreign key with onDelete('set null')
            $table->foreign('inventory_item_id')
                ->references('id')
                ->on('inventory_items')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 1. sales_details table rollback
        Schema::table('sales_details', function (Blueprint $table) {
            $table->dropForeign(['inventory_item_id']);
            $table->unsignedBigInteger('inventory_item_id')->nullable(false)->change();
            $table->foreign('inventory_item_id')
                ->references('id')
                ->on('inventory_items')
                ->onDelete('cascade');
        });

        // 2. purchase_details table rollback
        Schema::table('purchase_details', function (Blueprint $table) {
            $table->dropForeign(['inventory_item_id']);
            $table->unsignedBigInteger('inventory_item_id')->nullable(false)->change();
            $table->foreign('inventory_item_id')
                ->references('id')
                ->on('inventory_items')
                ->onDelete('cascade');
        });
    }
};
