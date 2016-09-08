<?php
namespace TuaWebsite\Repositories;

use TuaWebsite\Domain\Records\Score;
use TuaWebsite\Domain\Records\ScoreRepositoryInterface;

/**
 * Score Repository (Eloquent)
 *
 * @package TuaWebsite\Repositories
 * @author
 * @version 0.1.0
 * @since   0.1.0
 */
class EloquentScoreRepository implements ScoreRepositoryInterface
{
    /** @inheritDoc */
    public function add(Score $score)
    {
        $score->save();
    }

    /** @inheritDoc */
    public function update(Score $score)
    {
        $score->save();
    }

    /** @inheritDoc */
    public function get($score_id)
    {
        return Score::find($score_id);
    }

    /** @inheritDoc */
    public function byArcher($archer_id)
    {
        return Score::where('archer_id', $archer_id);
    }
}