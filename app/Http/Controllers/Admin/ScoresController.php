<?php
namespace TuaWebsite\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use TuaWebsite\Application\ScoringService;
use TuaWebsite\Domain\Identity\User;
use TuaWebsite\Domain\Records\BowClass;
use TuaWebsite\Domain\Records\Round;
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
    // Dependencies ----
    /** @var ScoringService */
    private $scoringService;

    // Setup ----
    public function __construct(ScoringService $scoringService)
    {
        $this->scoringService = $scoringService;

        $this->middleware('auth');
    }

    // Actions ----
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // Get chart data
        $bow_class_popularity = $this->scoringService->bowClassPopularity();
        $round_popularity     = $this->scoringService->roundPopularity();

        // Get the periodic counts
        $weekly_scores  = $this->scoringService->countScoresShotThisWeek();
        $monthly_scores = $this->scoringService->countScoresShotThisMonth();
        $yearly_scores  = $this->scoringService->countScoresShotThisAcademicYear();
        $all_scores     = $this->scoringService->countAllScores();

        // Get recent scores
        $recent_scores = $this->scoringService->recentlyShotScores(5);

        return view(
            'admin.scores.index',
            compact('bow_class_popularity', 'round_popularity', 'all_scores', 'yearly_scores', 'monthly_scores', 'weekly_scores', 'recent_scores')
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $users       = User::all();
        $rounds      = Round::all();
        $bow_classes = BowClass::all();

        return view(
            'admin.scores.create',
            compact('users', 'rounds', 'bow_classes')
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        // Grab the properties specified in the request
        $properties = array_values(
            $request->only([
                'archer_id',
                'scorer_id',
                'round_id',
                'bow_class',
                'shot_at',
                'total_score',
                'hit_count',
                'gold_count'
            ])
        );

        try{
            // Attempt to submit the score
            $this->scoringService->submitScore(...$properties);
        }
        catch (\InvalidArgumentException $ex){
            return abort(400, $ex->getMessage()); #TODO: Can Laravel not handle this automatically?
        }

        return redirect(
            route('admin.scores.index')
        );
    }
}
