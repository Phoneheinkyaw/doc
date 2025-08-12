<?php

namespace App\Console\Commands;

use App\Models\Appointment;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateMissedAppointments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-missed-appointments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update appointment status to missed if the due date has passed';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $today = Carbon::today();
        $count = 0;

        $appointments = Appointment::where('appointment_date', '<', $today)
            ->whereIn('status', [config('constants.statuses.pending'), config('constants.statuses.confirmed')])
            ->get();

        foreach ($appointments as $appointment) {
            $appointment->status = config('constants.statuses.missed');
            $appointment->save();
            $count++;

            if ($appointment->room_id !== null) {
                $this->info("$appointment->room_id");
                Room::where('id', $appointment->room_id)->update(['status' => true]);
            }
        }
        $this->info("Updated $count appointments to missed.");
    }
}
