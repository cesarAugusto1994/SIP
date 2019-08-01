<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\TemporaryFile;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'App\Console\Commands\ScheduleReminder',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('snooze:send')->everyMinute();
        $schedule->command('schedule:reminder')->everyMinute();
/*
        $schedule->call(function () {

            $files = TemporaryFile::all();

            $files->map(function($file) {

              if($file->created_at < now()->addMinutes(1)) {

                if(Storage::exists($file->path)) {
                    Storage::delete($file->path);
                }

                $file->delete();

              }

            });

        })->everyMinute();*/
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
