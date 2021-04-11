<?php
declare(strict_types = 1);
namespace Com\Incoders\SampleMS\Domain\Command\File;

use Psr\Container\ContainerInterface;
use Com\Incoders\SampleMS\Infrastructure\Service\CloudStorage\BucketService;

class UploadFileHandlerFactory
{
    public function __invoke(ContainerInterface $container): UploadFileHandler
    {
        $bucket = $container->has(BucketService::class)
        ? $container->get(BucketService::class)
        : null;

        return new UploadFileHandler(
            $bucket
        );
    }
}
