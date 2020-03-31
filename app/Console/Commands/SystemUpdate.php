<?php

namespace TuaWebsite\Console\Commands;

use Illuminate\Console\Command;

/**
 * System Update
 *
 * @package TuaWebsite\Console\Commands
 * @author  James Drew <jdrew@hotmail.co.uk>
 * @version 0.1.0
 * @since   0.8.0 Introduced this command (superseded "SystemUpgrade")
 */
class SystemUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update system to the latest released version';

    /**
     * Execute the console command
     */
    public function handle()
    {
        // Put the system into maintenance mode
        $this->call('down');

        // Run migrations and clear the framework cache
        $this->call('migrate', ['--force' => true]);
        $this->call('cache:clear');

        // Bring the system back up
        $this->call('up');
    }
}
