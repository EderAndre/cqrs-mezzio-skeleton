<?php

declare(strict_types=1);

namespace Com\Incoders\Cqrs\Application\Factories\Application\Cqs;

use Psr\Container\ContainerInterface;
use Com\Incoders\Cqrs\Application\Cqs\ApplicationBus;

class ApplicationBusFactory
{
    public function __invoke(ContainerInterface $container):ApplicationBus
    {
        return ApplicationBus::instance($container);
    }
}
