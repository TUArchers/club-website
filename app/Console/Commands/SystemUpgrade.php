<?php

namespace TuaWebsite\Console\Commands;

use Illuminate\Console\Command;

/**
 * System Upgrade
 *
 * @package TuaWebsite\Console\Commands
 * @author  James Drew <jdrew@hotmail.co.uk>
 * @version 0.1.0
 * @since   0.1.0
 */
class SystemUpgrade extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'upgrade';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upgrade system to the latest released version';

    /**
     * Create a new command instance
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command
     */
    public function handle()
    {
        // Put the system into maintenance mode
        $this->call('down');

        // Perform migrations
        $this->call('migrate');

        // Bring the system back up
        $this->call('up');
    }
}
