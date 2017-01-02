<?php

namespace TuaWebsite\Console\Commands;

use Illuminate\Console\Command;

/**
 * System Upgrade
 *
 * @package TuaWebsite\Console\Commands
 * @author  James Drew <jdrew@hotmail.co.uk>
 * @version 0.1.0
 * @since   0.1.0 Introduced this command
 * @since   0.3.0 Added zip archive extracting functionality
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
     * The name of the archive that is used for system upgrades
     *
     * @var string
     */
    protected $archive_name = 'upgrade.zip';

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

        // Extract the contents of the upgrade archive and perform database migrations
        try{
            $this->extractUpgradeFiles($this->archive_name);
            $this->call('migrate', ['--force' => true]);
        }
        catch(\Exception $ex){
            \Log::error($ex->getMessage(), $ex->getTrace());
        }

        // Clear up by removing the upgrade archive
        unlink($this->archive_name);

        // Bring the system back up
        $this->call('up');
    }

    /**
     * @param string $archive_name
     */
    private function extractUpgradeFiles($archive_name)
    {
        $archive = new \ZipArchive();

        if(!$archive->open($archive_name)){
            throw new \RuntimeException('Could not extract files from ' . $archive_name);
        }

        // Cleanly replace the vendor directory, if included in the archive
        if($archive->statName('vendor/autoload.php')){
            $this->removeDirectory(base_path() . '/vendor');
        }

        // Extract the archive contents
        $archive->extractTo(base_path());
        $archive->close();
    }

    /**
     * Remove a directory and it's contents
     *
     * @param string $path
     */
    private function removeDirectory($path) {
        $files = glob($path . '/*');

        foreach ($files as $file) {
            is_dir($file) ? $this->removeDirectory($file) : unlink($file);
        }

        rmdir($path);
    }
}
