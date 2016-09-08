<?php

namespace TuaWebsite\Domain\Event;

/**
 * Event Type Repository Interface
 *
 * @package TuaWebsite\Domain\Event
 * @author
 * @version 0.1.0
 * @since   0.1.0
 */
interface EventTypeRepositoryInterface
{
    /**
     * @param EventType $event_type
     */
    public function add(EventType $event_type);

    /**
     * @param EventType $event_type
     */
    public function update(EventType $event_type);

    /**
     * @param int $event_type_id
     *
     * @return EventType
     */
    public function get($event_type_id);
}