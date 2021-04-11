<?php
declare(strict_types = 1);
namespace Com\Incoders\SampleMS\Domain\Query\SampleMS;

use Com\Incoders\SampleMS\Infrastructure\Persistence\Repository\RepositoryFactory;
use Com\Incoders\SampleMS\Infrastructure\Persistence\Repository\SampleMSRepository ;

class SampleMSGetOneHandlerFactory
{
    public function __invoke(): SampleMSGetOneHandler
    {
        return new SampleMSGetOneHandler(RepositoryFactory::useRepository(SampleMSRepository::class));
    }
}
