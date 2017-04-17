<?php
namespace TuaWebsite\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use TuaWebsite\Domain\Identity\Organisation;
use TuaWebsite\Domain\Records\Round;
use TuaWebsite\Domain\Records\Score;
use TuaWebsite\Domain\Records\Season;
use TuaWebsite\Http\Controllers\Controller;

/**
 * Rounds Controller
 *
 * @package TuaWebsite\Http\Controllers\Admin
 * @author  James Drew <jdrew9@hotmail.co.uk>
 * @version 0.1.0
 * @since   0.1.0 Introduced this class
 */
class RoundsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rounds = Round::all();

        return view('admin.rounds.index', compact('rounds'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $organisations   = Organisation::all();
        $scoring_systems = Round::scoringSystems();

        return view('admin.rounds.create', compact('organisations', 'scoring_systems'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Check related objects exist
        $organisation   = Organisation::find($request->get('organisation_id'));
        $season         = Season::find($request->get('season'));
        $scoring_system = Round::scoringSystem($request->get('scoring_system_id'));

        // Prepare round data
        $round_data                 = $request->only(['name', 'total_targets', 'total_shots']);
        $round_data['organisation'] = $organisation->id;
        $round_data['season']       = $season->id;

        // Calculate score data for the round
        $score_values = explode(', ', $scoring_system);
        $round_data['max_shot_score'] = $score_values[0];
        $round_data['min_shot_score'] = end($score_values);
        $round_data['max_score'] =  $round_data['total_shots'] * $round_data['max_shot_score'];

        // Attempt to create and store the round
        /** @var Round $round */
        $round = Round::create($round_data);

        // Show on-screen confirmation and redirect
        $this->flash('Done!', $round->name . ' has been defined', 'green');

        return redirect(
            route('admin.rounds.show', $round->id)
        );

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $round         = Round::find($id);
        $record_scores = $this->getRecordScoresForRound($id);
        $recent_scores = $this->getRecentScoresForRound($id);

        return view('admin.rounds.show', compact('round', 'record_scores', 'recent_scores'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    // Internals ----
    /**
     * @param int $id
     *
     * @return Collection|Score[]
     */
    private function getRecordScoresForRound($id)
    {
        $subQuery = \DB::table('scores')
            ->select(\DB::raw('MAX(total_score) as total_score, round_id, bow_class'))
            ->where('scores.round_id', $id)
            ->groupBy('bow_class', 'round_id');

        return Score::from('scores as s')
            ->select(\DB::raw('s.round_id, s.archer_id, s.bow_class, s.total_score, MIN(s.shot_at) AS shot_at'))
            ->join('rounds as r', 's.round_id', '=', 'r.id')
            ->join('users as u', 's.archer_id', '=', 'u.id')
            ->join(\DB::raw('(' . $subQuery->toSql() . ') as recs'), function(JoinClause $join){
                $join->on('recs.round_id', '=', 's.round_id');
                $join->on('recs.bow_class', '=', 's.bow_class');
                $join->on('recs.total_score', '=', 's.total_score');
            })
            ->groupBy('s.round_id', 's.bow_class', 's.archer_id')
            ->orderBy('s.bow_class')
            ->mergeBindings($subQuery)
            ->get();
    }

    /**
     * @param int $id
     *
     * @return Collection|Score[]
     */
    private function getRecentScoresForRound($id)
    {
        return Score::where('round_id', $id)
            ->orderBy('shot_at', 'desc')
            ->take(5)
            ->get();
    }
}
