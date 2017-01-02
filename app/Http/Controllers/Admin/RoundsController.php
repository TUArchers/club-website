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
            ->select(\DB::raw('MAX(total_score) as rec, round_id, bow_class'))
            ->where('scores.round_id', $id)
            ->groupBy('bow_class', 'round_id');

        $allRecords = Score::from('scores as s')
            ->where('s.round_id', $id)
            ->join(\DB::raw('(' . $subQuery->toSql() . ') as recs'), function(JoinClause $join){
                $join->on('recs.round_id', '=', 's.round_id');
                $join->on('recs.bow_class', '=', 's.bow_class');
                $join->on('recs.rec', '=', 's.total_score');
            })
            ->join('rounds as r', 's.round_id', '=', 'r.id')
            ->orderBy('s.total_score', 'desc')
            ->orderBy('s.shot_at', 'asc')
            ->mergeBindings($subQuery)
            ->get();

        return $this->filterRecords($allRecords);
    }

    /**
     * @param Collection $scores
     *
     * @return Collection
     */
    private function filterRecords(Collection $scores)
    {
        // TODO: While this achieves the same thing, it should be possible to do this at database level. This isn't disastrous though, as there are unlikely to be a large number of equalled records

        $bow_class = [];

        return $scores->filter(function(Score $score) use(&$bow_class){
            if(!in_array($score->bow_class, $bow_class)){
                $bow_class[] = $score->bow_class;
                return true;
            }
            return false;
        });
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
