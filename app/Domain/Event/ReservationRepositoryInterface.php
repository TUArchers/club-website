<?php

namespace TuaWebsite\Domain\Event;

/**
 * Reservation Repository Interface
 *
 * @package TuaWebsite\Domain\Event
 * @author
 * @version 0.1.0
 * @since   0.1.0
 */
interface ReservationRepositoryInterface
{
    /**
     * @param Reservation $reservation
     */
    public function add(Reservation $reservation);

    /**
     * @param Reservation $reservation
     */
    public function update(Reservation $reservation);

    /**
     * @param int $reservation_id
     *
     * @return Reservation
     */
    public function get($reservation_id);
}