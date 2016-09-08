<?php
namespace TuaWebsite\Repositories;

use TuaWebsite\Domain\Event\Reservation;
use TuaWebsite\Domain\Event\ReservationRepositoryInterface;

/**
 * Reservation Repository
 *
 * @package TuaWebsite\Repositories
 * @author
 * @version 0.1.0
 * @since   0.1.0
 */
class EloquentReservationRepository implements ReservationRepositoryInterface
{
    /** @inheritDoc */
    public function add(Reservation $reservation)
    {
        $reservation->save();
    }

    /** @inheritDoc */
    public function update(Reservation $reservation)
    {
        $reservation->save();
    }

    /** @inheritDoc */
    public function get($reservation_id)
    {
        return Reservation::find($reservation_id);
    }
}