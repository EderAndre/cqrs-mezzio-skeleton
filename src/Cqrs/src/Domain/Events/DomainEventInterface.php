<?php

declare(strict_types=1);

namespace Com\Incoders\Cqrs\Domain\Events;

use \DateTimeImmutable;

interface DomainEventInterface
{
    public function getOcurredOn() : DateTimeImmutable;
}
