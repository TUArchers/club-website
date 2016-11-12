<?php

namespace TuaWebsite\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use TuaWebsite\Domain\Identity\User;
use TuaWebsite\Domain\Records\BowClass;
use TuaWebsite\Domain\Records\Round;
use TuaWebsite\Domain\Records\Score;
use TuaWebsite\Http\Controllers\Controller;

/**
 * Scores Controller (Admin)
 *
 * @package TuaWebsite\Http\Controllers\Admin
 * @author  James Drew <jdrew9@hotmail.co.uk>
 * @version 0.1.1
 * @since   0.1.0 Introduced this controller
 * @since   0.3.0 Fixed a bug when calculating scores submitted for the academic year
 */
class ScoresController extends Controller
{
    // Setup ----
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Actions ----
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get the current date and time
        $now = Carbon::now();

        // Get chart data
        $bow_class_popularity = $this->bowStylePopularity();
        $round_popularity     = $this->roundPopularity();

        // Get the periodic counts
        $weekly_scores  = $this->scoresRecordedSince($now->startOfWeek());
        $monthly_scores = $this->scoresRecordedSince($now->startOfMonth());
        $yearly_scores  = $this->scoresRecordedSince($this->academicYearStartDate($now));
        $all_scores     = Score::all()->count();

        // Get recent scores
        $recent_scores = $this->recentScores();

        return view('admin.scores.index', compact('bow_class_popularity', 'round_popularity', 'all_scores', 'yearly_scores', 'monthly_scores', 'weekly_scores', 'recent_scores'));
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
        $bow_classes = BowClass::all();

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
     * @param Carbon $start
     * @param Carbon $end
     *
     * @return Collection
     */
    private function bowStylePopularity(Carbon $start = null, Carbon $end = null)
    {
        $query = \DB::table('scores')->select(['bow_class', \DB::raw('count(*) as count')]);

        if(!is_null($start)){
            $query->where('shot_at', '>=', $start);
        }
        if(!is_null($end)){
            $query->where('shot_at', '>=', $end);
        }

        $results = $query->groupBy('bow_class')->orderBy('bow_class', 'asc')->get();

        return $results->map(function($result){
            $result->bow_class = BowClass::find($result->bow_class);
            return $result;
        });
    }

    /**
     * @param Carbon $start
     * @param Carbon $end
     *
     * @return Collection
     */
    private function roundPopularity(Carbon $start = null, Carbon $end = null)
    {
        $query = \DB::table('scores')->select(['rounds.name', \DB::raw('count(*) as count')])
            ->leftJoin('rounds', 'scores.round_id', '=', 'rounds.id');

        if(!is_null($start)){
            $query->where('shot_at', '>=', $start);
        }
        if(!is_null($end)){
            $query->where('shot_at', '>=', $end);
        }

        return $query->groupBy('rounds.name')->orderBy('rounds.name', 'asc')->get();
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
     * @return Collection|Score[]
     */
    private function recentScores()
    {
        return Score::orderBy('shot_at', 'desc')
            ->take(5)
            ->get();
    }

    /**
     * Calculate the start of the academic year for the given date
     *
     * @param Carbon $now
     *
     * @return Carbon
     */
    private function academicYearStartDate(Carbon $now)
    {
        $yearStart = $now->copy()->month(9)->startOfMonth();
        if($now->month < 9){
            $yearStart->subYear();
        }

        return $yearStart;
    }
}
