<?php

declare(strict_types=1);

namespace Com\Incoders\Cqrs\Application\Cqs;

interface CommandHandlerInterface
{
    public function handle(CommandInterface $command) : void;
}
