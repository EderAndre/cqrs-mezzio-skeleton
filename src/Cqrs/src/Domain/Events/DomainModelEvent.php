<?php
declare(strict_types = 1);
namespace Com\Incoders\Cqrs\Domain\Events;

use Com\Incoders\Cqrs\Domain\Events\RecordsEventsInterface;
use Com\Incoders\Cqrs\Domain\Events\IsEventSourcedInterface;
use Com\Incoders\Cqrs\Domain\Events\DomainEventInterface;
use Com\Incoders\Cqrs\Domain\Events\DomainEvents;

abstract class DomainModelEvent implements RecordsEventsInterface
{

    protected $recordedEvents = [];

    protected function recordThat(DomainEventInterface $aDomainEvent)
    {
        $this->recordedEvents[] = $aDomainEvent;
    }

    public function getRecordedEvents()
    {
        return new DomainEvents($this->recordedEvents);
    }

    public function clearRecordedEvents()
    {
        $this->recordedEvents = [];
    }
}
