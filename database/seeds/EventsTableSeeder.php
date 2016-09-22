<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

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
            'name'          => 'Session A',
            'starts_at'     => '2016-10-04 17:00:00',
            'ends_at'       => '2016-10-04 17:40:00',
            'location_name' => 'T6.10 (Middlesbrough Tower)',
            'capacity'      => 24,
            'invite_only'   => false,
            'members_only'  => false,
        ],
        [
            'type_id'       => 1,
            'name'          => 'Session B',
            'starts_at'     => '2016-10-04 18:00:00',
            'ends_at'       => '2016-10-04 18:40:00',
            'location_name' => 'T6.10 (Middlesbrough Tower)',
            'capacity'      => 24,
            'invite_only'   => false,
            'members_only'  => false,
        ],
        [
            'type_id'       => 1,
            'name'          => 'Session C',
            'starts_at'     => '2016-10-04 19:00:00',
            'ends_at'       => '2016-10-04 19:40:00',
            'location_name' => 'T6.10 (Middlesbrough Tower)',
            'capacity'      => 24,
            'invite_only'   => false,
            'members_only'  => false,
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
