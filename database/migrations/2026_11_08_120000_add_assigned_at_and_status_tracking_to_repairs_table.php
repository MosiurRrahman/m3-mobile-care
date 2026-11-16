<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('repairs', function (Blueprint $table) {
            if (!Schema::hasColumn('repairs', 'assigned_at')) {
                $table->timestamp('assigned_at')->nullable()->after('assigned_technician_id');
            }
            if (!Schema::hasColumn('repairs', 'status_updated_at')) {
                $table->timestamp('status_updated_at')->nullable()->after('status');
            }
            if (!Schema::hasColumn('repairs', 'status_history')) {
                $table->json('status_history')->nullable()->after('status_updated_at');
            }
        });

        // Backfill existing repair tickets
        try {
            // Set assigned_at for tickets that already have an assigned technician
            DB::table('repairs')
                ->whereNotNull('assigned_technician_id')
                ->whereNull('assigned_at')
                ->update([
                    'assigned_at' => DB::raw('created_at')
                ]);

            // Set status_updated_at for existing tickets
            DB::table('repairs')
                ->whereNull('status_updated_at')
                ->update([
                    'status_updated_at' => DB::raw('COALESCE(completed_at, updated_at, created_at)')
                ]);
        } catch (\Throwable $e) {
            Log::warning('Failed backfilling assigned_at or status_updated_at for repairs: ' . $e->getMessage());
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('repairs', function (Blueprint $table) {
            $cols = [];
            if (Schema::hasColumn('repairs', 'assigned_at')) {
                $cols[] = 'assigned_at';
            }
            if (Schema::hasColumn('repairs', 'status_updated_at')) {
                $cols[] = 'status_updated_at';
            }
            if (Schema::hasColumn('repairs', 'status_history')) {
                $cols[] = 'status_history';
            }
            if (!empty($cols)) {
                $table->dropColumn($cols);
            }
        });
    }
};
