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
            'name'          => 'Taster Session A',
            'starts_at'     => '2016-09-30 17:00:00',
            'ends_at'       => '2016-09-30 19:00:00',
            'location_name' => 'Brittan Building Foyer',
            'capacity'      => 24,
            'invite_only'   => false,
            'members_only'  => false,
        ],
        [
            'type_id'       => 1,
            'name'          => 'Taster Session B',
            'starts_at'     => '2016-09-30 19:00:00',
            'ends_at'       => '2016-09-30 21:00:00',
            'location_name' => 'Brittan Building Foyer',
            'capacity'      => 24,
            'invite_only'   => false,
            'members_only'  => false,
        ],
        [
            'type_id'       => 1,
            'name'          => 'Taster Session C',
            'starts_at'     => '2016-10-01 10:00:00',
            'ends_at'       => '2016-10-01 12:00:00',
            'location_name' => 'Brittan Building Foyer',
            'capacity'      => 24,
            'invite_only'   => false,
            'members_only'  => false,
        ],
        [
            'type_id'       => 1,
            'name'          => 'Taster Session D',
            'starts_at'     => '2016-10-01 12:00:00',
            'ends_at'       => '2016-10-01 14:00:00',
            'location_name' => 'Brittan Building Foyer',
            'capacity'      => 24,
            'invite_only'   => false,
            'members_only'  => false,
        ],
        [
            'type_id'       => 1,
            'name'          => 'Taster Session E',
            'starts_at'     => '2016-10-01 14:00:00',
            'ends_at'       => '2016-10-01 16:00:00',
            'location_name' => 'Brittan Building Foyer',
            'capacity'      => 24,
            'invite_only'   => false,
            'members_only'  => false,
        ],
        [
            'type_id'       => 1,
            'name'          => 'Taster Session F',
            'starts_at'     => '2016-10-01 16:00:00',
            'ends_at'       => '2016-10-01 18:00:00',
            'location_name' => 'Brittan Building Foyer',
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
