<?php
declare(strict_types = 1);

namespace Com\Incoders\SampleMS\Application\Action\SampleMS;

use Psr\Container\ContainerInterface;
use Com\Incoders\Cqrs\Application\Cqs\ApplicationBus;

class AddSampleMSHandlerFactory
{
    public function __invoke(ContainerInterface $container): AddSampleMSHandler
    {
        return new AddSampleMSHandler(
            new ApplicationBus($container)
        );
    }
}
