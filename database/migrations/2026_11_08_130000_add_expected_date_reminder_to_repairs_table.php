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
            if (!Schema::hasColumn('repairs', 'expected_date_reminder_sent_at')) {
                $table->timestamp('expected_date_reminder_sent_at')->nullable()->after('expected_delivery_date');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('repairs', function (Blueprint $table) {
            if (Schema::hasColumn('repairs', 'expected_date_reminder_sent_at')) {
                $table->dropColumn('expected_date_reminder_sent_at');
            }
        });
    }
};
