<?php

namespace TuaWebsite\Console\Commands;

use Illuminate\Console\Command;
use TuaWebsite\Domain\Event\ReservationRepositoryInterface;

/**
 * "Remove Expired Event Reservations" Command
 *
 * @package TuaWebsite\Console\Commands
 * @author
 * @version 0.1.0
 * @since   0.1.0
 */
class RemoveExpiredEventReservations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calendar:clear-expiries';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove all event reservations that have expired without being confirmed';

    /** @var ReservationRepositoryInterface */
    private $reservations;

    /**
     * Create a new command instance
     *
     * @param ReservationRepositoryInterface $reservationRepository
     */
    public function __construct(ReservationRepositoryInterface $reservationRepository)
    {
        parent::__construct();

        $this->reservations = $reservationRepository;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->reservations->removeListed(
            $this->reservations->findExpiredReservations()
        );
    }
}
