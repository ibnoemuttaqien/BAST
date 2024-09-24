<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Absensi;
use Carbon\Carbon;
use App\Models\User;


class MarkAbsent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'absensi:mark-absent';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mark users as absent if they did not register attendance within 24 hours.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Get the current date and time
        $now = Carbon::now();

        // Get all users
        $users = User::all();

        foreach ($users as $user) {
            // Check if there is an attendance record for today
            $attendanceExists = Absensi::where('id_user', $user->id)
                ->whereDate('created_at', $now->toDateString())
                ->exists();

            // If no attendance record exists, mark the user as absent
            if (!$attendanceExists) {
                Absensi::create([
                    'id_user' => $user->id,
                    'kehadiran' => 'tidak_hadir',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }

        $this->info('Users who did not register attendance within 24 hours have been marked as absent.');
    }
}
