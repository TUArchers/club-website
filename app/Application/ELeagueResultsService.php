<?php
namespace TuaWebsite\Application;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use TuaWebsite\Domain\Identity\ExperienceLevel;
use TuaWebsite\Domain\Records\BowClass;

/**
 * E League Results Service
 *
 * @package TuaWebsite\Application
 * @author  James Drew <jdrew9@hotmail.co.uk>
 * @version 1.0.0
 */
class ELeagueResultsService
{
    // Constants ----
    const OPEN_TEAM_SIZE   = 4;
    const NOVICE_TEAM_SIZE = 3;
    const ROUND_NAME       = 'Portsmouth';
    const BOW_CLASSES      = 'B, C, R, L';
    const STUDENT_STATUS   = true;
    const STAGES           = 5;

    const STAGE_1_START    = 9;
    const STAGE_1_END      = 10;
    const STAGE_2_START    = 11;
    const STAGE_2_END      = 11;
    const STAGE_3_START    = 12;
    const STAGE_3_END      = 1;
    const STAGE_4_START    = 2;
    const STAGE_4_END      = 2;
    const STAGE_5_START    = 3;
    const STAGE_5_END      = 3;

    // Queries ----
    /**
     * Get a collection of all scores eligible for the specified E-League season
     *
     * @author  James Drew <jdrew9@hotmail.co.uk>
     * @version 1.0.0
     *
     * @param int $seasonStartYear
     *
     * @return Collection
     */
    public function allEligibleScores($seasonStartYear)
    {
        // Get the start and end dates for the specified season
        $seasonDates = $this->seasonStartAndEndDates($seasonStartYear);

        // Find the eligible scores in the given season
        $scores = $this->findEligibleScoresForSeason($seasonDates['startDate'], $seasonDates['endDate']);

        return $scores;
    }

    /**
     * Get a collection of all scores eligible for the specified E-League season, grouped into stages
     *
     * @author  James Drew <jdrew9@hotmail.co.uk>
     * @version 1.0.0
     *
     * @param int $seasonStartYear
     *
     * @return Collection
     */
    public function allEligibleScoresGroupedByStage($seasonStartYear)
    {
        // Get the start and end dates for the specified season
        $seasonDates = $this->seasonStartAndEndDates($seasonStartYear);

        // Find the eligible scores in the given season
        $scores = $this->findEligibleScoresForSeason($seasonDates['startDate'], $seasonDates['endDate']);

        // Group the scores into stages
        $stages = $this->groupScoresIntoStages($scores, $this->stagesDates($seasonStartYear));

        return $stages;
    }

    /**
     * Get the season start and end dates as Carbon objects
     *
     * @author  James Drew <jdrew9@hotmail.co.uk>
     * @version 1.0.0
     *
     * @param int $seasonStartYear
     *
     * @return Carbon[]
     */
    public function seasonStartAndEndDates($seasonStartYear)
    {
        $startDate = Carbon::createFromDate($seasonStartYear, self::STAGE_1_START)->startOfMonth();
        $endDate   = Carbon::createFromDate($seasonStartYear + 1, self::STAGE_5_END)->endOfMonth();

        return compact('startDate', 'endDate');
    }

    /**
     * Get an array of stage start and end dates as Carbon objects
     *
     * @author  James Drew <jdrew9@hotmail.co.uk>
     * @version 1.0.0
     *
     * @param int $seasonStartYear
     *
     * @return array
     */
    public function stagesDates($seasonStartYear)
    {
        $year = $seasonStartYear;

        $stages = [];
        for($i=1; $i <= self::STAGES; $i++){

            // Grab the start and end months from constants
            $startMonth = constant(self::class . '::STAGE_' . $i .'_START');
            $endMonth   = constant(self::class . '::STAGE_' . $i . '_END');

            // Make the start date object
            $startDate = Carbon::create($year, $startMonth)->startOfMonth();

            // Increment the year once January is hit
            if($endMonth < $startMonth){
                $year ++;
            }

            // Make the end date object
            $endDate = Carbon::create($year, $endMonth)->endOfMonth();

            // Add to the stages array
            $stages[$i] = [
                'start' => $startDate,
                'end'   => $endDate,
            ];
        }

        return $stages;
    }

    // Internals ----
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
    private function findEligibleScoresForSeason(Carbon $start, Carbon $end)
    {
        // Prepare the query
        $query = \DB::table('scores')
            ->selectRaw('scores.*, rounds.name, rounds.max_score, users.first_name, users.last_name, users.experience_level')
            ->join('rounds', 'scores.round_id', '=', 'rounds.id')
            ->join('users', 'scores.archer_id', '=', 'users.id')
            ->where('rounds.name', self::ROUND_NAME)
            ->whereBetween('scores.shot_at', [$start, $end])
            ->where('users.is_student', self::STUDENT_STATUS)
            ->whereIn('scores.bow_class', explode(', ', self::BOW_CLASSES));

        // Run the query and order the results by the score they achieved
        return $query->orderBy('total_score', 'desc')->get();
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
     * Make a stage DTO
     *
     * @author  James Drew <jdrew9@hotmail.co.uk>
     * @version 1.0.0
     *
     * @param Carbon     $start
     * @param Carbon     $end
     * @param Collection $scores
     * @param Collection $teams
     *
     * @return \stdClass
     */
    private function makeStageObject(Carbon $start, Carbon $end, Collection $scores, Collection $teams)
    {
        $stage = new \stdClass();

        $stage->name   = $start->month == $end->month? $start->format('M') : $start->format('M') . '-' . $end->format('M');
        $stage->start  = $start;
        $stage->end    = $end;
        $stage->scores = $scores;
        $stage->teams  = $teams;

        return $stage;
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

    /**
     * Group scores into stages
     *
     * @author  James Drew <jdrew9@hotmail.co.uk>
     * @version 1.0.0
     *
     * @param Collection $results
     * @param array      $stages
     *
     * @return Collection
     */
    private function groupScoresIntoStages(Collection $results, array $stages)
    {
        $groupedScores = [];

        foreach($stages as $stageNumber => $dates){
            /** @var Carbon[] $dates */

            // Filter out the scores for this stage
            $stageScores = $results->filter(function($score) use($dates){
                $shot_at = Carbon::parse($score->shot_at);
                return $shot_at->gte($dates['start']) && $shot_at->lte($dates['end']);
            });

            // Parse the score data into an object and calculate team scores
            $scores = $this->parseScoreData($stageScores);
            $teams  = Collection::make([
                'Open Recurve'   => $this->calculateTeamScore($scores, Collection::make([BowClass::barebow(), BowClass::recurve()])),
                'Novice Recurve' => $this->calculateTeamScore($scores, Collection::make([BowClass::barebow(), BowClass::recurve()]), 3, true),
                'Compound'       => $this->calculateTeamScore($scores, Collection::make([BowClass::compound()])),
            ]);

            // Construct a DTO with the data for this stage
            $stage = $this->makeStageObject($dates['start'], $dates['end'], $scores, $teams);

            // Add the stage to the grouped scores
            $groupedScores[$stageNumber] = $stage;
        }

        return Collection::make($groupedScores);
    }
}