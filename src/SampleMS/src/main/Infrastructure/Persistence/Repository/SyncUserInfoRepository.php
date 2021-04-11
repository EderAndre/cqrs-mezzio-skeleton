<?php
declare(strict_types = 1);
namespace Com\Incoders\SampleMS\Infrastructure\Persistence\Repository;

use Com\Incoders\SampleMS\Infrastructure\Persistence\Repository\Entity\SyncUserInfo;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SyncUserInfoRepository extends SyncUserInfo implements RepositoryInterface
{

    public function findAll(): LengthAwarePaginator
    {
        return SyncUserInfoRepository::paginate();
    }

    public function findById($userId): ?SyncUserInfo
    {
        return SyncUserInfoRepository::find($userId);
    }
}
