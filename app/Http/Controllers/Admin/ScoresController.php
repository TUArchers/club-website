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
        // Calculate the date this academic year started
        $months_passed = 9 - Carbon::now()->month;
        $year_start    = Carbon::now()->subMonths($months_passed)->startOfMonth();

        // Get the period counts
        $yearly_scores  = $this->scoresRecordedSince($year_start);
        $monthly_scores = $this->scoresRecordedSince(Carbon::now()->startOfMonth());
        $weekly_scores  = $this->scoresRecordedSince(Carbon::now()->startOfWeek());

        // Get club records
        $records = new Collection();
        foreach(Round::all() as $round){
            $score = $this->highScoreForRound($round);

            if($score){
                $records->add($score);
            }
        }

        return view('admin.scores.index', compact('yearly_scores', 'monthly_scores', 'weekly_scores', 'records'));
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

    /**
     * @param Carbon $date
     *
     * @return int
     */
    private function scoresRecordedSince(Carbon $date)
    {
        return Score::where('shot_at', '>=', $date)->count();
    }

    /**
     * @param Round $round
     *
     * @return Score|null
     */
    private function highScoreForRound(Round $round)
    {
        return Score::where('round_id', '=', $round->id)->orderBy('total_score', 'desc')->first();
    }
}
