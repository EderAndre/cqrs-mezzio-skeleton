<?php
declare(strict_types = 1);
namespace Com\Incoders\SampleMS\Domain\Command\SampleMS;

use Psr\Container\ContainerInterface;
use Com\Incoders\SampleMS\Infrastructure\Persistence\Repository\SampleMSRepository;
use Com\Incoders\SampleMS\Infrastructure\Persistence\Repository\RepositoryFactory;
use Com\Incoders\Cqrs\Infrastructure\Persistence\EventStore\PDOEventStore;

class SaveSampleMSHandlerFactory
{
    public function __invoke(ContainerInterface $container): SaveSampleMSHandler
    {
        $repo = RepositoryFactory::useRepository(SampleMSRepository::class);

        return new SaveSampleMSHandler($container, $repo, new PDOEventStore());
    }
}
