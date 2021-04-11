<?php

declare(strict_types=1);

namespace Com\Incoders\Cqrs\Infrastructure\Persistence\Projections;

use Com\Incoders\Cqrs\Domain\Events\DomainEvents;
use Com\Incoders\Cqrs\Domain\Events\ProjectionInterface;
use Com\Incoders\Cqrs\Domain\Events\DomainEventInterface;
use Com\Incoders\Cqrs\Infrastructure\Persistence\Projections\PersistenceManager;

abstract class BaseProjection extends PersistenceManager implements ProjectionInterface
{
    public function project(DomainEvents $eventStream)
    {
        foreach ($eventStream as $event) {
            $projectMethod = $this->extractNameMethod($event);

            $this->$projectMethod($event);
        }
    }

    private function extractNameMethod(DomainEventInterface $event) : String
    {
        $lasWordOfMethod = explode('.', str_replace('\\', '.', get_class($event)));
        $lasWordOfMethod = end($lasWordOfMethod);

        return lcfirst($lasWordOfMethod);
    }
}
