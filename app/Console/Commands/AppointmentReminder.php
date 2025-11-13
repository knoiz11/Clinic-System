<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appointment;
use App\Models\Notification;
use Carbon\Carbon;

class AppointmentReminder extends Command
{
    protected $signature = 'appointments:remind';
    protected $description = 'Send appointment reminders to users';

    public function handle()
    {
        $now = Carbon::now();

        $intervals = [
            1440 => 'Your appointment is tomorrow.',     // 1 day before
            30   => 'Your appointment is in 30 minutes.', // 30 minutes before
            5    => 'Your appointment is in 5 minutes.',  // 5 minutes before
        ];

        foreach ($intervals as $minutes => $message) {
            $targetTime = $now->copy()->addMinutes($minutes);

            $startTime = $targetTime->copy()->subMinute();
            $endTime   = $targetTime->copy()->addMinute();

            $appointments = \App\Models\Appointment::whereDate('date', $targetTime->toDateString())
                ->whereTime('time', '>=', $startTime->format('H:i:s'))
                ->whereTime('time', '<=', $endTime->format('H:i:s'))
                ->get();

            foreach ($appointments as $appointment) {
                // Use created_by as the user who made the appointment
                $userId = $appointment->created_by ?? 1;

                // Avoid duplicate reminders
                $exists = \App\Models\Notification::where('message', "Reminder: {$message} (Employee: {$appointment->employee_name})")
                    ->whereDate('created_at', Carbon::today())
                    ->exists();

                if (!$exists) {
                    \App\Models\Notification::create([
                        'user_id' => $userId,
                        'message' => "Reminder: {$message} (Employee: {$appointment->employee_name})",
                        'is_read' => false,
                    ]);
                }
            }
        }

        $this->info('Appointment reminders checked and notifications created.');
    }

}
