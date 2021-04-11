<?php
declare(strict_types = 1);
namespace Com\Incoders\SampleMS\Infrastructure\Persistence\Repository;

use Com\Incoders\SampleMS\Infrastructure\Persistence\Repository\Entity\SampleMS;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SampleMSRepository extends SampleMS implements RepositoryInterface
{
    public function findAll(): LengthAwarePaginator
    {
        return SampleMSRepository::paginate();
    }

    public function findById($userId): ?SampleMS
    {
        return SampleMSRepository::find($userId);
    }
}
