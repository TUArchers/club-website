<?php
namespace TuaWebsite\Application;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use TuaWebsite\Domain\Identity\ExperienceLevel;
use TuaWebsite\Domain\Records\BowClass;
use TuaWebsite\Domain\Records\Round;
use TuaWebsite\Domain\Records\Score;
use TuaWebsite\Domain\Records\TeamScore;

/**
 * Scoring Service
 *
 * @package TuaWebsite\Application
 * @author  James Drew <jdrew9@hotmail.co.uk>
 * @version 0.1.0
 * @since   0.3.0 Introduced this service
 */
class ScoringService
{
    // Dependencies ----
    //

    // Setup ----
    public function __construct()
    {
        //
    }

    // Commands ----
    /**
     * Submit a new score
     *
     * @param int    $archer_id
     * @param int    $scorer_id
     * @param int    $round_id
     * @param string $bow_class
     * @param string $shot_at
     * @param int    $total_score
     * @param int    $hit_count
     * @param int    $gold_count
     *
     * @return int
     */
    public function submitScore($archer_id, $scorer_id, $round_id, $bow_class, $shot_at, $total_score, $hit_count, $gold_count)
    {
        // Validate that the round exists, and that the score, hits and golds states is possible
        $this->validateScoreProperties($round_id, $total_score, $hit_count, $gold_count);

        // Create and store the new score
        $score_data            = compact('archer_id', 'scorer_id', 'round_id', 'bow_class', 'shot_at', 'total_score', 'hit_count', 'gold_count');
        $score_data['shot_at'] = Carbon::createFromFormat('Y-m-d H:i', $score_data['shot_at']);

        /** @var Score $score */
        $score = Score::create($score_data);

        return $score->id;
    }

    // Queries ----
    /**
     * Get the total number of submitted scores
     *
     * @return int
     */
    public function countAllScores()
    {
        return \DB::table('scores')->count();
    }

    /**
     * Get the total number of submitted scores that were shot during the current calendar week
     *
     * @return int
     */
    public function countScoresShotThisWeek()
    {
        $week_start = Carbon::now()->startOfWeek();
        $week_end   = $week_start->copy()->endOfWeek();

        return \DB::table('scores')
            ->whereBetween('shot_at', [$week_start, $week_end])
            ->count();
    }

    /**
     * Get the total number of submitted scores that were shot in the current calendar month
     *
     * @return int
     */
    public function countScoresShotThisMonth()
    {
        $month_start = Carbon::now()->startOfMonth();
        $month_end   = $month_start->copy()->endOfMonth();

        return \DB::table('scores')
            ->whereBetween('shot_at', [$month_start, $month_end])
            ->count();
    }

    /**
     * Get the total number of submitted scores that were shot during the current academic year
     *
     * @return int
     */
    public function countScoresShotThisAcademicYear()
    {
        $academicYear = $this->calculateAcademicYearDates(Carbon::now());

        return \DB::table('scores')
            ->whereBetween('shot_at', $academicYear)
            ->count();
    }

    /**
     * Get a collection of scores that were shot recently
     *
     * @param int $limit
     *
     * @return Score[]|Collection
     */
    public function recentlyShotScores($limit = 5)
    {
        return Score::orderBy('shot_at', 'desc')
            ->take($limit)
            ->get();
    }

    /**
     * Get a collection of statistics showing how many scores have been submitted for each bow class
     *
     * @return array[]|Collection
     */
    public function bowClassPopularity()
    {
        // Prepare the query
        $query = \DB::table('scores')->select([
            'bow_class',
            \DB::raw('count(*) as count')
        ]);

        // Run the prepared query and order the results
        $results = $query->groupBy('bow_class')
            ->orderBy('bow_class', 'asc')
            ->get();

        // Map BowClass objects on the result set
        return $results->map(function($result){
            $result->bow_class = BowClass::find($result->bow_class);
            return $result;
        });
    }

    /**
     * Get a collection of statistics showing how many scores have been submitted for each round
     *
     * @return array[]|Collection
     */
    public function roundPopularity()
    {
        // Prepare the query
        $query = \DB::table('scores')->select([
                'rounds.name',
                \DB::raw('count(*) as count')
            ])
            ->leftJoin('rounds', 'scores.round_id', '=', 'rounds.id');

        // Run the prepared query and order the results
        return $query->groupBy('rounds.name')
            ->orderBy('rounds.name', 'asc')
            ->get();
    }

    /**
     * Get all the scores that are eligible for E-League in the current academic year
     *
     * @return Collection
     */
    public function scoresEligibleForELeague()
    {
        // Calculate the start and end dates for this year's competition
        $academicYear = $this->calculateAcademicYearDates(Carbon::now());
        $start        = $academicYear['year_start'];
        $end          = $start->copy()->addYear()->month(3)->endOfMonth();

        // Get the results
        $results = $this->findELeagueEligibleScores($start, $end);

        // Group the results into the competition stages and return
        return $this->groupELeagueResultsIntoStages($results, $academicYear);
    }

    // Internals ----
    /**
     * @param int $round_id
     * @param int $total_score
     * @param int $hit_count
     * @param int $gold_count
     *
     * @throws \InvalidArgumentException If gold count exceeds hit count
     * @throws \InvalidArgumentException If the round stated doesn't allow the score or hit count stated
     * @throws \InvalidArgumentException If the score stated is not mathematically possible for the stated round
     */
    private function validateScoreProperties($round_id, $total_score, $hit_count, $gold_count)
    {
        // Check that the gold count is possible, given the number of hits
        if($gold_count > $hit_count){
            throw new \InvalidArgumentException(
                sprintf("It's not possible to score %s golds with %s hits", $gold_count, $hit_count)
            );
        }

        /** @var Round $round */
        $round = Round::findOrFail($round_id);

        // Check that the score, hit count are possible in the stated round
        if($total_score > $round->max_score || $hit_count > $round->total_shots){
            throw new \InvalidArgumentException(
                sprintf("It's not possible to score %s with %s hits in a %s round", $total_score, $hit_count, $round->name)
            );
        }

        // Check that the score claimed is mathematically possible
        $non_gold_count = $hit_count - $gold_count;
        $max_score      = ($round->max_shot_score * $gold_count) + ($non_gold_count * $round->getScoreForRing(2));
        $min_score      = ($round->max_shot_score * $gold_count) + ($non_gold_count * $round->min_shot_score);

        if($total_score < $min_score || $total_score > $max_score){
            throw new \InvalidArgumentException(
                sprintf("It's not possible to score %s with %s hits and %s golds in a %s round", $total_score, $hit_count, $gold_count, $round->name)
            );
        }
    }
    
    /**
     * @param Carbon $date
     *
     * @return Carbon[]
     */
    private function calculateAcademicYearDates(Carbon $date)
    {
        // Academic year starts on the first of September
        $year_start = $date->copy()
            ->month(9)
            ->startOfMonth();

        // If the calendar year has progressed then the academic year started in the previous calendar year
        if($date->month < 9){
            $year_start->subYear();
        }

        // Academic year ends at the end of August
        $year_end = $year_start->copy()
            ->addYear()
            ->subDay()
            ->endOfDay();

        return compact('year_start', 'year_end');
    }

    /**
     * Find all scores that are eligible for E-League between two dates
     *
     * @author  James Drew <jdrew9@hotmail.co.uk>
     * @version 1.0.0
     *
     * @param Carbon $start
     * @param Carbon $end
     *
     * @return Collection
     */
    private function findELeagueEligibleScores(Carbon $start, Carbon $end)
    {
        // Prepare the query
        $query = \DB::table('scores')
            ->selectRaw('scores.*, rounds.name, rounds.max_score, users.first_name, users.last_name, users.experience_level')
            ->join('rounds', 'scores.round_id', '=', 'rounds.id')
            ->join('users', 'scores.archer_id', '=', 'users.id')
            ->where('rounds.name', 'Portsmouth')
            ->whereBetween('scores.shot_at', [$start, $end])
            ->where('users.is_student', true)
            ->whereIn('scores.bow_class', ['B', 'C', 'R', 'L']);

        // Run the query and order the results by the score they achieved
        return $query->orderBy('total_score', 'desc')->get();
    }
    
    /**
     * @param Collection $results
     * @param array      $academicYear
     *
     * @return Collection
     */
    private function groupELeagueResultsIntoStages(Collection $results, array $academicYear)
    {
        // This defines the start and end months for each E-League stage
        $year   = $academicYear['year_start']->year;
        $stages = [
            1 => [
                'start' => 9,
                'end'   => 10,
            ],
            2 => [
                'start' => 11,
                'end'   => 11,
            ],
            3 => [
                'start' => 12,
                'end'   => 1,
            ],
            4 => [
                'start' => 2,
                'end'   => 2,
            ],
            5 => [
                'start' => 3,
                'end'   => 3,
            ]
        ];

        // Loop over the defined stage months and fill in this year's start and end dates,
        // along with the scores for that round
        foreach ($stages as $stage_number => &$stage){

            // Calculate the start and end dates of the stage
            $stage_start = Carbon::createFromDate($year, $stage['start'], 1);

            if($stage['end'] < $stage['start']){
                $year ++;
            }

            $stage_end   = Carbon::createFromDate($year, $stage['end'])->endOfMonth();

            // Filter out the scores for this stage and parse them
            $stage_scores = $results->filter(function($score) use($stage_start, $stage_end){
                $shot_at = Carbon::parse($score->shot_at);

                return $shot_at->gte($stage_start) && $shot_at->lte($stage_end);
            });
            $scores       = $this->parseScoreData($stage_scores);

            // Assign the dates and scores to the stage
            $stage['name']         = $stage['start'] != $stage['end']?
                $stage_start->format('M') . ' - ' . $stage_end->format('M'):
                $stage_start->format('M');
            $stage['start']        = $stage_start;
            $stage['end']          = $stage_end;
            $stage['scores']       = $scores;
            $stage['teams']        = [
                'Open Recurve'   => $this->calculateTeamScore($scores, Collection::make([BowClass::barebow(), BowClass::recurve()])),
                'Novice Recurve' => $this->calculateTeamScore($scores, Collection::make([BowClass::barebow(), BowClass::recurve()]), 3, true),
                'Compound'       => $this->calculateTeamScore($scores, Collection::make([BowClass::compound()])),
            ];
        }

        return new Collection($stages);
    }
    
    /**
     * @param Collection $scores
     *
     * @return Collection
     */
    private function parseScoreData(Collection $scores)
    {
        $parsedScores = [];

        foreach($scores as $score){
            $parsed = new \stdClass();

            $parsed->shot_at          = Carbon::parse($score->shot_at);
            $parsed->created_at       = Carbon::parse($score->created_at);
            $parsed->archer_id        = $score->archer_id;
            $parsed->archer_name      = trim(
                sprintf('%s %s', $score->first_name, $score->last_name)
            );
            $parsed->experience_level = ExperienceLevel::find($score->experience_level)->name;
            $parsed->bow_class        = BowClass::find($score->bow_class)->name;
            $parsed->round_name       = $score->name;
            $parsed->round_max_score  = $score->max_score;
            $parsed->total_score      = $score->total_score;
            $parsed->hit_count        = $score->hit_count;
            $parsed->gold_count       = $score->gold_count;

            $parsedScores[] = $parsed;
        }

        return new Collection($parsedScores);
    }

    /**
     * Calculate a team score from a set of individual scores
     *
     * @author  James Drew <jdrew9@hotmail.co.uk>
     * @version 1.0.0
     *
     * @param Collection $scores
     * @param Collection $bowClasses
     * @param int        $teamSize
     * @param bool       $noviceOnly
     *
     * @return TeamScore
     */
    private function calculateTeamScore(Collection $scores, Collection $bowClasses, $teamSize = 4, $noviceOnly = false)
    {
        // Filter the scores according to the given criteria
        $filteredScores = $scores->filter(function($score) use($bowClasses, $noviceOnly){

            $isValidBowClass = $bowClasses->contains(function(BowClass $bowClass) use($score){
                return $bowClass->name == $score->bow_class;
            });

            return $noviceOnly? 'Novice' == $score->experience_level && $isValidBowClass : $isValidBowClass;

        })->sortByDesc('total_score');

        // Prepare a container for the team scores
        $teamScores = [];

        // Find the top unique archers from the filtered scores
        foreach($filteredScores as $score){

            // If the team is already full, stop looping
            if(count($teamScores) >= $teamSize){
                continue;
            }

            // Add this score to the team score if this is a unique archer
            if(!isset($teamScores[$score->archer_id])){
                $teamScores[$score->archer_id] = $score;
            }
        }

        return TeamScore::fromIndividualScores(
            Collection::make($teamScores),
            $teamSize
        );
    }
}