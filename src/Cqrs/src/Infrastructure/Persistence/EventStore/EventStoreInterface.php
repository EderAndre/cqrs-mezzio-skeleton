<?php

namespace Com\Incoders\Cqrs\Infrastructure\Persistence\EventStore;

use Com\Incoders\Cqrs\Domain\Events\DomainEvents;

interface EventStoreInterface
{
    /**
     * @param DomainEvents $events
     *
     * @return void
     */
    public function commit(DomainEvents $events);
}
