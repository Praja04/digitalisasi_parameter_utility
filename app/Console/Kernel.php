<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Tambahkan command yang dibuat di sini, jika ada
        // Commands\SendStatusEmail::class,
        Commands\SendCustomerEmails::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    //     protected function schedule(Schedule $schedule)
    //     {
    //         $schedule->command('send:status-email')->hourly();
    //   // Mengirim email setiap jam
    //     }


    protected function schedule(Schedule $schedule)
    {
        $schedule->command('send:customer-emails')->everyMinute();
    }



    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
