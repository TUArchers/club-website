<?php
namespace TuaWebsite\Application;

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
    public $max_score;
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
     * @param int        $size
     * @param Collection $teamScores
     * @param int        $max_score
     * @param int        $totalScore
     * @param int        $hitCount
     * @param int        $goldCount
     */
    private function __construct(array $teamMembers, $size, Collection $teamScores, $max_score, $totalScore, $hitCount, $goldCount)
    {
        $this->members      = $teamMembers;
        $this->size         = $size;
        $this->team_scores  = $teamScores;
        $this->max_score    = $max_score;
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
     * @param int        $maxTeamSize
     *
     * @return TeamScore
     */
    public static function fromIndividualScores(Collection $scores, $maxTeamSize)
    {
        $teamMembers = [];
        $teamSize    = 0;
        $totalScore  = 0;
        $hitCount    = 0;
        $goldCount   = 0;

        foreach($scores as $score){
            $teamMembers[] = $score->archer_name;
            $teamSize      ++;
            $totalScore    += $score->total_score;
            $hitCount      += $score->hit_count;
            $goldCount     += $score->gold_count;
        }

        $teamMaxScore = $teamSize > 0? $maxTeamSize * $scores->first()->round_max_score : 0;

        return new self($teamMembers, $teamSize, $scores, $teamMaxScore, $totalScore, $hitCount, $goldCount);
    }
}