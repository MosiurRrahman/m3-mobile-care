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
        Schema::create('special_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('item_name');
            $table->string('brand')->nullable();
            $table->string('device_model')->nullable();
            $table->string('source_supplier')->nullable(); // e.g. Dhaka Motaleb Plaza, Local Vendor
            $table->decimal('estimated_cost', 10, 2)->default(0.00); // Cost price from supplier
            $table->decimal('courier_cost', 10, 2)->default(0.00); // Transport / Courier charge
            $table->decimal('selling_price', 10, 2)->default(0.00); // Total price for customer
            $table->decimal('advance_paid', 10, 2)->default(0.00); // Advance deposit
            $table->decimal('due_amount', 10, 2)->default(0.00); // Remaining balance
            $table->string('advance_payment_method')->nullable(); // Cash, bKash, Nagad, etc.
            $table->string('final_payment_method')->nullable();
            $table->string('status')->default('pending'); // pending, ordered_from_dhaka, received_in_shop, delivered, cancelled
            $table->date('expected_delivery_date')->nullable();
            $table->text('notes')->nullable();
            $table->string('branch')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamp('received_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('special_orders');
    }
};
