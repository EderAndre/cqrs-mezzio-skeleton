<?php

declare(strict_types=1);

namespace Com\Incoders\Cqrs\Application\Cqs;

interface QueryHandlerInterface
{
    public function handle(QueryInterface $query = null);
}
