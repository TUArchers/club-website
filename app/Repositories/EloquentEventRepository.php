<?php
namespace TuaWebsite\Repositories;

use TuaWebsite\Domain\Event\Event;
use TuaWebsite\Domain\Event\EventRepositoryInterface;

/**
 * Event Repository
 *
 * @package TuaWebsite\Persistence
 * @author
 * @version 0.1.0
 * @since   0.1.0
 */
class EloquentEventRepository implements EventRepositoryInterface
{
    /** @inheritDoc */
    public function add(Event $event)
    {
        $event->save();
    }

    /** @inheritDoc */
    public function update(Event $event)
    {
        $event->save();
    }

    /** @inheritDoc */
    public function get($event_id)
    {
        return Event::find($event_id);
    }

    /** @inheritDoc */
    public function findPublicEvents()
    {
        return Event::openToPublic()->inFuture()->get();
    }
}