<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use TuaWebsite\Model\Events\Event;

/**
 * Events Table Seeder
 *
 * @author
 * @version 0.1.0
 * @since   0.1.0
 */
class EventsTableSeeder extends Seeder
{
    /** @var array  */
    private $events = [
        [
            'type_id'       => 1,
            'name'          => 'Session A (20th Sep @ 5pm)',
            'starts_at'     => '2016-09-20 17:00:00',
            'ends_at'       => '2016-09-20 17:40:00',
            'location_name' => 'T6.10 (Middlesbrough Tower)',
            'capacity'      => 24,
            'privacy'       => Event::P_PUBLIC,
        ],
        [
            'type_id'       => 1,
            'name'          => 'Session B (20th Sep @ 6pm)',
            'starts_at'     => '2016-09-20 18:00:00',
            'ends_at'       => '2016-09-20 18:40:00',
            'location_name' => 'T6.10 (Middlesbrough Tower)',
            'capacity'      => 24,
            'privacy'       => Event::P_PUBLIC,
        ],
        [
            'type_id'       => 1,
            'name'          => 'Session C (20th Sep @ 7pm)',
            'starts_at'     => '2016-09-20 19:00:00',
            'ends_at'       => '2016-09-20 19:40:00',
            'location_name' => 'T6.10 (Middlesbrough Tower)',
            'capacity'      => 24,
            'privacy'       => Event::P_PUBLIC,
        ],
    ];

    /**
     * Run the database seeds
     */
    public function run()
    {
        foreach($this->events as $event){

            $event['created_at'] = Carbon::now();

            DB::table('events')->insert($event);
        }
    }
}
