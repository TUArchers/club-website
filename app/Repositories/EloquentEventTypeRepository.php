<?php
namespace TuaWebsite\Repositories;

use TuaWebsite\Domain\Event\EventType;
use TuaWebsite\Domain\Event\EventTypeRepositoryInterface;

/**
 * Event Type Repository
 *
 * @package TuaWebsite\Repositories
 * @author
 * @version 0.1.0
 * @since   0.1.0
 */
class EloquentEventTypeRepository implements EventTypeRepositoryInterface
{
    /** @inheritDoc */
    public function add(EventType $event_type)
    {
        $event_type->save();
    }

    /** @inheritDoc */
    public function update(EventType $event_type)
    {
        $event_type->save();
    }

    /** @inheritDoc */
    public function get($event_type_id)
    {
        return EventType::find($event_type_id);
    }
}