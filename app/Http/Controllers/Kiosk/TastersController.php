<?php

namespace TuaWebsite\Http\Controllers\Kiosk;

use Illuminate\Support\Collection;
use TuaWebsite\Domain\Event\Event;
use TuaWebsite\Domain\Event\EventType;
use TuaWebsite\Domain\Identity\Gender;
use TuaWebsite\Http\Controllers\Controller;
use TuaWebsite\Http\Requests;

/**
 * Tasters Controller
 *
 * @package TuaWebsite\Http\Controllers\Kiosk
 * @author
 * @version 0.1.0
 * @since   0.1.0
 */
class TastersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $type   = EventType::where('name', 'Taster Session')->first();
        $events = Event::where('type_id', $type)->get();

        $genders = Gender::all();

        $schools        = $this->arrayToCollection([
            'SCM'   => 'School of Computing',
            'DCA'   => 'School of Design, Culture and the Arts',
            'SOH'   => 'School of Health & Social Care',
            'SSE'   => 'School of Science & Engineering',
            'SSSBL' => 'School of Social Sciences, Business and Law',
            'STAFF' => 'University Staff',
            'ASSOC' => 'University Associates and Alumni',
            'O'     => 'Other'
        ]);
        $subjects       = $this->arrayToCollection([
            'Sc'  => 'Science',
            'A'   => 'Art',
            'Ed'  => 'Education',
            'Eng' => 'Engineering',
            'Ph'  => 'Philosophy',
            'BA'  => 'Business Administration',
            'O'   => 'Other',
            'NA'  => 'Not Applicable'
        ]);
        $qualifications = $this->arrayToCollection([
            'Dip' => 'Diploma',
            'Fd'  => 'Foundation Degree',
            'B'   => 'Bachelor\'s Degree',
            'M'   => 'Master\'s Degree',
            'D'   => 'Doctorate',
            'O'   => 'Other',
            'NA'  => 'Not Applicable'
        ]);
        $years          = $this->arrayToCollection([
            '1' => '1',
            '2' => '2',
            '3' => '3',
            '4' => '4',
            '5' => '5',
            '6' => '6',
            '7' => '7+',
            'NA' => 'Not Applicable'
        ]);

        return view('kiosk.tasters', compact('events', 'genders', 'schools', 'subjects', 'qualifications', 'years'));
    }

    // Internals ----
    /**
     * @param array $array
     *
     * @return Collection|\stdClass[]
     */
    private function arrayToCollection(array $array)
    {
        $objects = [];
        foreach($array as $key => $value){
            $obj = new \stdClass();
            $obj->id   = $key;
            $obj->name = $value;

            $objects[] = $obj;
        }

        return new Collection($objects);
    }
}
