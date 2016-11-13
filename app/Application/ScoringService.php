<?php
namespace TuaWebsite\Application;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use TuaWebsite\Domain\Records\BowClass;
use TuaWebsite\Domain\Records\Round;
use TuaWebsite\Domain\Records\Score;

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
}