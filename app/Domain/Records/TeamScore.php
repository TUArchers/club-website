<?php
namespace TuaWebsite\Domain\Records;

use Illuminate\Support\Collection;

/**
 * Team Score
 *
 * Note that this takes a collection of parsed score data rather than score objects
 *
 * @package TuaWebsite\Domain\Records
 * @author  James Drew <jdrew9@hotmail.co.uk>
 * @version 1.0.0
 */
class TeamScore
{
    // Properties ----
    /** @var string[] */
    public $members;
    /** @var int */
    public $size;
    /** @var Collection */
    public $team_scores;
    /** @var int */
    public $total_score;
    /** @var int */
    public $hit_count;
    /** @var int */
    public $gold_count;

    // Setup ----
    /**
     * TeamScore constructor.
     *
     * @param array      $teamMembers
     * @param Collection $teamScores
     * @param int        $totalScore
     * @param int        $hitCount
     * @param int        $goldCount
     */
    private function __construct(array $teamMembers, Collection $teamScores, $totalScore, $hitCount, $goldCount)
    {
        $this->members      = $teamMembers;
        $this->size         = count($teamMembers);
        $this->team_scores  = $teamScores;
        $this->total_score  = $totalScore;
        $this->hit_count    = $hitCount;
        $this->gold_count   = $goldCount;
    }

    /**
     * Calculate a team score from a set of individual scores
     *
     * @author  James Drew <jdrew9@hotmail.co.uk>
     * @version 1.0.0
     *
     * @param Collection $scores
     *
     * @return TeamScore
     */
    public static function fromIndividualScores(Collection $scores)
    {
        $teamMembers = [];
        $totalScore  = 0;
        $hitCount    = 0;
        $goldCount   = 0;

        foreach($scores as $score){
            $teamMembers[] = $score->archer_name;
            $totalScore    += $score->total_score;
            $hitCount      += $score->hit_count;
            $goldCount     += $score->gold_count;
        }

        return new self($teamMembers, $scores, $totalScore, $hitCount, $goldCount);
    }
}