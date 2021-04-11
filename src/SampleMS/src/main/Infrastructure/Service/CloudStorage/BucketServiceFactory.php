<?php
declare(strict_types = 1);
namespace Com\Incoders\SampleMS\Infrastructure\Service\CloudStorage;

use Com\Incoders\Cqrs\Infrastructure\Persistence\EventStore\PDOEventStore;
use Google\Cloud\Storage\StorageClient;
use Psr\Container\ContainerInterface;

class BucketServiceFactory
{
    public function __invoke(ContainerInterface $container): BucketService
    {
        $configs = $container->get('config')['google-cloud-storage'];
        $bucketName = $configs['CLOUD_STORAGE_BUCKET'];
        return new BucketService(new StorageClient(), $bucketName, new PDOEventStore());
    }
}
