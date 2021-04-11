<?php
declare(strict_types = 1);

namespace Com\Incoders\SampleMS\Application\Action\File;

use Psr\Container\ContainerInterface;
use Com\Incoders\Cqrs\Application\Cqs\ApplicationBus;

class DirectoryListHandlerFactory
{
    public function __invoke(ContainerInterface $container): DirectoryListHandler
    {
        return new DirectoryListHandler(
            new ApplicationBus($container)
        );
    }
}
