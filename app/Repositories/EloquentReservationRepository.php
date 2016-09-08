<?php
namespace TuaWebsite\Repositories;

use Carbon\Carbon;
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
    public function remove(Reservation $reservation)
    {
        $reservation->delete();
    }

    /** @inheritDoc */
    public function removeListed(\Traversable $reservations)
    {
        foreach($reservations as $reservation){
            $this->remove($reservation);
        }
    }

    /** @inheritDoc */
    public function get($reservation_id)
    {
        return Reservation::find($reservation_id);
    }

    /** @inheritDoc */
    public function findExpiredReservations()
    {
        return Reservation::where([
            ['expires_at', '<=', Carbon::now()],
            ['confirmed_at', null],
        ])->get();
    }
}