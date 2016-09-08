<?php
namespace TuaWebsite\Repositories;

use TuaWebsite\Domain\Records\Round;
use TuaWebsite\Domain\Records\RoundRepositoryInterface;

/**
 * Round Repository (Eloquent)
 *
 * @package TuaWebsite\Repositories
 * @author
 * @version 0.1.0
 * @since   0.1.0
 */
class EloquentRoundRepository implements RoundRepositoryInterface
{
    /** @inheritDoc */
    public function add(Round $round)
    {
        $round->save();
    }

    /** @inheritDoc */
    public function update(Round $round)
    {
        $round->save();
    }

    /** @inheritDoc */
    public function get($round_id)
    {
        return Round::find($round_id);
    }
}