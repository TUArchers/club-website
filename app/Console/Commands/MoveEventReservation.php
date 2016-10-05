<?php

namespace TuaWebsite\Console\Commands;

use Illuminate\Console\Command;
use TuaWebsite\Domain\Event\EventRepositoryInterface;
use TuaWebsite\Domain\Event\ReservationRepositoryInterface;
use TuaWebsite\Domain\Identity\UserRepositoryInterface;

/**
 * "Move Event Reservation" Command
 *
 * @package TuaWebsite\Console\Commands
 * @author
 * @version 0.1.0
 * @since   0.1.0
 */
class MoveEventReservation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calendar:move-reservation {user-identity} {event-identity} {new-event-identity}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Move a reservation from one event to another';

    /**
     * @var UserRepositoryInterface
     */
    private $users;

    /**
     * @var EventRepositoryInterface
     */
    private $events;

    /**
     * @var ReservationRepositoryInterface
     */
    private $reservations;

    /**
     * Create a new command instance
     *
     * @param UserRepositoryInterface $userRepository
     * @param EventRepositoryInterface $eventRepository
     * @param ReservationRepositoryInterface $reservationRepository
     */
    public function __construct(UserRepositoryInterface $userRepository, EventRepositoryInterface $eventRepository, ReservationRepositoryInterface $reservationRepository)
    {
        parent::__construct();

        $this->users        = $userRepository;
        $this->events       = $eventRepository;
        $this->reservations = $reservationRepository;
    }

    /**
     * Execute the console command.
     *
     * @throws \Exception
     */
    public function handle()
    {
        // Get the user and the original event
        $user  = $this->users->get($this->argument('user-identity'));
        $event = $this->events->get($this->argument('event-identity'));

        // Find their reservation
        $reservation = $event->reservations->where('attendee_id', $user->id)->first();
        if(!$reservation){
            throw new \Exception('That user has not reserved a space for that event');
        }

        // Get the new event and check it isn't full
        $newEvent = $this->events->get($this->argument('new-event-identity'));
        if($newEvent->is_full){
            throw new \Exception('That event is already full!');
        }

        // Modify the reservation
        $reservation->event()->associate($newEvent);
        $reservation->save();

        $this->info($user->name . ' has been moved from ' . $event->name . ' to ' . $newEvent->name);
    }
}
