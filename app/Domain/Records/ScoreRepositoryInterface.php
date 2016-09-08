<?php

namespace TuaWebsite\Domain\Records;

/**
 * Score Repository Interface
 *
 * @package TuaWebsite\Domain\News
 * @author
 * @version 0.1.0
 * @since   0.1.0
 */
interface ScoreRepositoryInterface
{
    /**
     * @param Score $score
     */
    public function add(Score $score);

    /**
     * @param Score $score
     */
    public function update(Score $score);

    /**
     * @param int $score_id
     *
     * @return Score
     */
    public function get($score_id);

    /**
     * @param int $archer_id
     *
     * @return Score[]
     */
    public function byArcher($archer_id);
}