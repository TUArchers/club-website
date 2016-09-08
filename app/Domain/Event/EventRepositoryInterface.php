<?php

namespace TuaWebsite\Domain\Event;

/**
 * Event Repository Interface
 *
 * @package TuaWebsite\Domain\Event
 * @author
 * @version 0.1.0
 * @since   0.1.0
 */
interface EventRepositoryInterface
{
    /**
     * @param Event $event
     */
    public function add(Event $event);

    /**
     * @param Event $event
     */
    public function update(Event $event);

    /**
     * @param int $event_id
     *
     * @return Event
     */
    public function get($event_id);

    /**
     * @return Event[]
     */
    public function findPublicEvents();
}