<?php
declare(strict_types = 1);
namespace Com\Incoders\SampleMS\Domain\Query\SampleMS;

use Com\Incoders\Cqrs\Application\Cqs\QueryHandlerInterface;
use Com\Incoders\Cqrs\Application\Cqs\QueryInterface;
use Com\Incoders\SampleMS\Infrastructure\Persistence\Repository\SampleMSRepository;

class SampleMSGetOneHandler implements QueryHandlerInterface
{
    public $sample;

    public function __construct(SampleMSRepository $sample)
    {
        $this->sample = $sample;
    }

    public function handle(QueryInterface $query = null): ?SampleMSRepository
    {
        return $this->sample->findById($query->params['id_equals']);
    }
}
