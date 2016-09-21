<?php

use Illuminate\Database\Seeder;

/**
 * DatabaseSeeder
 *
 * @author
 * @version 0.1.0
 * @since   0.1.0
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(EventsTableSeeder::class);
        $this->call(ScoresTableSeeder::class);
    }
}
