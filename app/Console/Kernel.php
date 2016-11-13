<?php
namespace TuaWebsite\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use TuaWebsite\Console\Commands\SystemUpgrade;

/**
 * Kernel
 *
 * @package TuaWebsite\Console
 * @author  James Drew <jdrew@hotmail.co.uk>
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
        SystemUpgrade::class,
        #RemoveExpiredEventReservations::class,
        #MoveEventReservation::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  Schedule $schedule
     */
    protected function schedule(Schedule $schedule)
    {
        // Handle queued jobs
        $schedule->command('queue:restart')
            ->everyThirtyMinutes();
        $schedule->exec('php artisan queue:work --queue=urgent,notifications,emails,default --timeout=0 --tries=10')
            ->everyThirtyMinutes();

        // Schedule next system upgrade when the upgrade file is provided
        $schedule->command('upgrade')
            ->everyMinute()
            ->evenInMaintenanceMode()
            ->when(function(){
                return file_exists('upgrade.zip');
            });
    }

    /**
     * Register the Closure based commands for the application.
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
