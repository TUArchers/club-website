<?php

namespace TuaWebsite\Domain\Records;

/**
 * Round Repository Interface
 *
 * @package TuaWebsite\Domain\News
 * @author
 * @version 0.1.0
 * @since   0.1.0
 */
interface RoundRepositoryInterface
{
    /**
     * @param Round $round
     */
    public function add(Round $round);

    /**
     * @param Round $round
     */
    public function update(Round $round);

    /**
     * @param int $round_id
     *
     * @return Round
     */
    public function get($round_id);
}