<?php

declare(strict_types = 1);

namespace Com\Incoders\SampleMS\Application\Action\SampleMS;

use Psr\Container\ContainerInterface;
use Com\Incoders\Cqrs\Application\Cqs\ApplicationBus;

class SampleMSGetOneHandlerFactory
{
    public function __invoke(ContainerInterface $container) : SampleMSGetOneHandler
    {
        return new SampleMSGetOneHandler(
            new ApplicationBus($container)
        );
    }
}
