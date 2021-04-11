<?php
declare(strict_types=1);

namespace Com\Incoders\Cqrs\Domain\Events;

use Com\Incoders\Cqrs\Domain\Events\DomainEvents;

interface ProjectionInterface
{
    public function project(DomainEvents $eventStream);
}
