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
            $table->json('device_checklist')->nullable();
            $table->json('device_photos')->nullable();
            $table->string('commission_type')->nullable(); // 'percentage', 'flat'
            $table->decimal('commission_rate', 10, 2)->default(0.00);
            $table->decimal('commission_amount', 10, 2)->default(0.00);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('repairs', function (Blueprint $table) {
            $table->dropColumn(['device_checklist', 'device_photos', 'commission_type', 'commission_rate', 'commission_amount']);
        });
    }
};
