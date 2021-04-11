<?php

declare(strict_types=1);

namespace Com\Incoders\Cqrs\Application\Cqs;

interface BusInterface
{
    public function executeCommand(CommandInterface $command);
    public function executeQuery(QueryInterface $query);
}
