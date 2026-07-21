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
        Schema::create('repairs', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_id')->unique();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('device_brand');
            $table->string('device_model');
            $table->string('serial_imei')->nullable();
            $table->text('issue_description');
            $table->string('password_pattern')->nullable(); // Pattern code or pin
            $table->string('status')->default('pending'); // pending, diagnosing, waiting_for_approval, repairing, quality_check, completed, delivered, cancelled
            $table->decimal('estimated_cost', 10, 2)->default(0.00);
            $table->decimal('advance_payment', 10, 2)->default(0.00);
            $table->decimal('actual_cost', 10, 2)->nullable();
            $table->text('technician_notes')->nullable();
            $table->unsignedBigInteger('assigned_technician_id')->nullable();
            $table->date('expected_delivery_date')->nullable();
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('set null');
            $table->foreign('assigned_technician_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repairs');
    }
};
