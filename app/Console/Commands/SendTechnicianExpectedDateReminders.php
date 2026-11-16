<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Repair;
use App\Models\Setting;
use App\Services\SmsService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class SendTechnicianExpectedDateReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'repairs:send-technician-reminders 
                            {--dry-run : Simulate check without dispatching SMS}
                            {--days=1 : Number of days before expected delivery date (default 1)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send automated SMS reminders to assigned technicians 1 day before the expected delivery date';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('[' . now()->toDateTimeString() . '] Starting technician expected date alert check...');

        $smsEnabled = Setting::get('sms_enabled', '0');
        $reminderEnabled = Setting::get('sms_send_to_technician_reminder', '1');
        $isDryRun = $this->option('dry-run');

        if (!$isDryRun) {
            if (!$smsEnabled) {
                $this->warn('SMS notifications are globally disabled in settings. Aborting.');
                return Command::SUCCESS;
            }

            if (!$reminderEnabled) {
                $this->warn('Technician expected date reminder SMS is disabled in settings. Aborting.');
                return Command::SUCCESS;
            }
        }

        $days = (int) $this->option('days');
        if ($days < 1) {
            $days = 1;
        }

        $targetDate = Carbon::today()->addDays($days)->toDateString();
        $this->info("Checking for repairs with expected delivery date: {$targetDate} ({$days} day(s) from today)");

        // Find active uncompleted repairs assigned to a technician with expected date = targetDate and no reminder sent yet
        $repairs = Repair::with(['technician', 'customer'])
            ->whereNotNull('assigned_technician_id')
            ->whereDate('expected_delivery_date', $targetDate)
            ->whereNotIn('status', ['completed', 'delivered', 'cancelled'])
            ->whereNull('expected_date_reminder_sent_at')
            ->get();

        $count = $repairs->count();
        $this->info("Found {$count} repair(s) eligible for technician reminder.");

        if ($count === 0) {
            $this->info('No eligible repairs found. Exiting.');
            return Command::SUCCESS;
        }

        if ($isDryRun) {
            $rows = $repairs->map(function ($repair) {
                return [
                    'Ticket ID' => $repair->ticket_id,
                    'Device' => $repair->device_brand . ' ' . $repair->device_model,
                    'Technician' => $repair->technician?->name ?? 'N/A',
                    'Tech Phone' => $repair->technician?->phone ?? 'N/A',
                    'Expected Date' => $repair->expected_delivery_date ? Carbon::parse($repair->expected_delivery_date)->format('Y-m-d') : 'N/A',
                    'Status' => $repair->status,
                ];
            });

            $this->table(['Ticket ID', 'Device', 'Technician', 'Tech Phone', 'Expected Date', 'Status'], $rows);
            $this->info('Dry-run mode: No SMS was dispatched.');
            return Command::SUCCESS;
        }

        $sentCount = 0;
        $failedCount = 0;

        foreach ($repairs as $repair) {
            $tech = $repair->technician;
            if (!$tech || empty($tech->phone)) {
                $this->warn("Skipping Ticket #{$repair->ticket_id}: Technician has no phone number.");
                $failedCount++;
                continue;
            }

            $this->line("Dispatching SMS for Ticket #{$repair->ticket_id} to {$tech->name} ({$tech->phone})...");

            $result = SmsService::sendTechnicianExpectedDateReminder($repair);

            if ($result['success']) {
                $repair->expected_date_reminder_sent_at = now();

                $history = is_array($repair->status_history) ? $repair->status_history : [];
                $history[] = [
                    'type' => 'sms_alert',
                    'status' => $repair->status,
                    'status_label' => Repair::statusLabels()[$repair->status] ?? ucfirst(str_replace('_', ' ', $repair->status)),
                    'technician_id' => $repair->assigned_technician_id,
                    'technician_name' => $tech->name,
                    'user_id' => null,
                    'user_name' => 'Automated Scheduler',
                    'note' => "Automated 1-day advance reminder SMS sent to technician {$tech->name} ({$tech->phone}) for expected date {$targetDate}",
                    'created_at' => now()->toDateTimeString(),
                ];
                $repair->status_history = $history;
                $repair->save();

                Log::info("Automated technician reminder SMS sent for Repair Ticket #{$repair->ticket_id} to {$tech->phone}");
                $this->info("✓ Successfully sent SMS for Ticket #{$repair->ticket_id}");
                $sentCount++;
            } else {
                Log::warning("Failed to send technician reminder SMS for Ticket #{$repair->ticket_id}: " . ($result['message'] ?? 'Unknown error'));
                $this->error("✗ Failed to send SMS for Ticket #{$repair->ticket_id}: " . ($result['message'] ?? 'Unknown error'));
                $failedCount++;
            }
        }

        $this->info("Completed. Sent: {$sentCount}, Failed/Skipped: {$failedCount}");

        return Command::SUCCESS;
    }
}
