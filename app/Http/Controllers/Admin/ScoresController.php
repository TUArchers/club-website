<?php

namespace TuaWebsite\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use TuaWebsite\Domain\Identity\User;
use TuaWebsite\Domain\Records\Round;
use TuaWebsite\Domain\Records\Score;
use TuaWebsite\Http\Controllers\Controller;

/**
 * Scores Controller (Admin)
 *
 * @package TuaWebsite\Http\Controllers\Admin
 * @author
 * @version 0.1.0
 * @since   0.1.0
 */
class ScoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $scores = Score::all();

        return view('admin.scores.index', compact('scores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users       = User::all();
        $rounds      = Round::all();
        $bow_classes = $this->getBowClasses();

        return view('admin.scores.create', compact('users', 'rounds', 'bow_classes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $score_data = $request->only(['archer_id', 'scorer_id', 'round_id', 'bow_class', 'shot_at', 'total_score', 'hit_count', 'gold_count']);
        $score_data['shot_at'] = Carbon::createFromFormat('Y-m-d H:i', $score_data['shot_at']);

        Score::create($score_data);

        return redirect(
            route('admin.scores.index')
        );
    }

    // Internals ----
    /**
     * @return Collection
     */
    private function getBowClasses()
    {
        $collection = new Collection();
        $classes = [
            ['id' => 'C', 'name' => 'Compound'],
            ['id' => 'R', 'name' => 'Recurve'],
            ['id' => 'B', 'name' => 'Barebow'],
            ['id' => 'L', 'name' => 'Longbow'],
            ['id' => 'T', 'name' => 'Traditional'],
        ];

        foreach ($classes as $class){
            $collection->add((object) $class);
        }

        return $collection;
    }
}
