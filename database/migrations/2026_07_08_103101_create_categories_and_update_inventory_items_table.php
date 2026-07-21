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
        // 1. Create categories table
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('status')->default('active'); // active, inactive
            $table->timestamps();
        });

        // 2. Add columns to inventory_items table
        Schema::table('inventory_items', function (Blueprint $table) {
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('sub_category')->nullable();
            $table->string('brand')->nullable();
            $table->text('description')->nullable();
            $table->string('product_type')->default('single'); // single, variable
            $table->string('discount_type')->nullable(); // flat, percentage
            $table->text('images')->nullable(); // JSON array
            $table->string('warranties')->nullable();
            $table->string('manufacturer')->nullable();
            $table->date('expiry')->nullable();
            $table->text('variants')->nullable(); // JSON array of variant details
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventory_items', function (Blueprint $table) {
            $table->dropColumn([
                'supplier_id',
                'category_id',
                'sub_category',
                'brand',
                'description',
                'product_type',
                'discount_type',
                'images',
                'warranties',
                'manufacturer',
                'expiry',
                'variants'
            ]);
        });

        Schema::dropIfExists('categories');
    }
};
