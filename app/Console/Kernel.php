<?php
namespace TuaWebsite\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use TuaWebsite\Console\Commands\MoveEventReservation;
use TuaWebsite\Console\Commands\RemoveExpiredEventReservations;

/**
 * Kernel
 *
 * @package TuaWebsite\Console
 * @author
 * @version 0.1.0
 * @since   0.1.0
 */
class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        RemoveExpiredEventReservations::class,
        MoveEventReservation::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     */
    protected function schedule(Schedule $schedule)
    {
        //$schedule->command('calendar:clear-expiries')->everyMinute();
        #$schedule->command('send:membership-info')->everyMinute();

        $schedule->command('queue:restart')->everyThirtyMinutes();
        $schedule->exec('php artisan queue:work --queue=urgent,notifications,emails,default --timeout=0 --tries=10')->everyThirtyMinutes();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
