<?php
namespace TuaWebsite\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use TuaWebsite\Console\Commands\MoveEventReservation;
use TuaWebsite\Console\Commands\RemoveExpiredEventReservations;
use TuaWebsite\Console\Commands\SystemUpdate;

/**
 * Kernel
 *
 * @package TuaWebsite\Console
 * @author  James Drew <jdrew@hotmail.co.uk>
 * @version 0.1.0
 * @since   0.1.0 Introduced this kernel
 * @since   0.3.0 Moved more upgrade functionality to a dedicated command
 * @since   0.8.0 Adjusted schedule to make use of "withoutOverlapping" for queue
 */
class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        SystemUpdate::class,
        RemoveExpiredEventReservations::class,
        MoveEventReservation::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  Schedule $schedule
     */
    protected function schedule(Schedule $schedule)
    {
        // Clear expired event reservations
        $schedule->command('calendar:clear-expiries')
            ->everyFiveMinutes();

        // Handle queued jobs
        $schedule->command('php artisan queue:work', ['queue' => 'urgent,notifications,emails,default', 'timeout' => 0, 'tries' => 5])
            ->everyMinute()
            ->withoutOverlapping();

        // Schedule next system upgrade when the upgrade file is provided
        $schedule->command('upgrade')
            ->everyMinute()
            ->evenInMaintenanceMode()
            ->when(function(){
                return file_exists('update.lock');
            });
    }

    /**
     * Register the Closure based commands for the application.
     */
    protected function commands()
    {
        /** @noinspection PhpIncludeInspection */
        require base_path('routes/console.php');
    }
}
