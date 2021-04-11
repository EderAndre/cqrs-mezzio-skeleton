<?php
declare(strict_types = 1);
namespace Com\Incoders\SampleMS\Domain\Query\File;

use Psr\Container\ContainerInterface;
use Com\Incoders\SampleMS\Infrastructure\Service\CloudStorage\BucketService;

class ListFilesHandlerFactory
{
    public function __invoke(ContainerInterface $container): ListFilesHandler
    {
        $bucket = $container->has(BucketService::class)
        ? $container->get(BucketService::class)
        : null;

        return new ListFilesHandler($bucket);
    }
}
