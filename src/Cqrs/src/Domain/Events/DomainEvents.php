<?php
declare(strict_types=1);

namespace Com\Incoders\Cqrs\Domain\Events;

class DomainEvents extends ImmutableArray
{
    /**
     * Throw when the type of item is not accepted.
     *
     * @param $item
     * @return void
     */
    protected function guardType($item)
    {
        if (!($item instanceof DomainEventInterface)) {
            throw new \TypeError('A DomainEvent muest be a DomainEventInterface istanceof');
        }
    }
}
