<?php
declare(strict_types = 1);
namespace Com\Incoders\SampleMS\Infrastructure\Persistence\Repository;

use Com\Incoders\SampleMS\Infrastructure\Persistence\Repository\Entity\AuthProtocolBufferCached;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class AuthProtocolBufferCachedRepository extends AuthProtocolBufferCached implements RepositoryInterface
{
    public function findAll(): LengthAwarePaginator
    {
        return AuthProtocolBufferCachedRepository::paginate();
    }

    public function findById($id): ?AuthProtocolBufferCached
    {
        return AuthProtocolBufferCachedRepository::find($id);
    }
    public function findUnexpiratedProtocol(
        $params = [
            'clientApiName'=>'',
            'userToken'=>null,
            'sqlTimestamp'=>null
        ]
    ) {
        $result= AuthProtocolBufferCachedRepository::where([
            [
                'clientApiName',
                '=',
                $params['clientApiName']
            ],
            [
                'userToken',
                '=',
                $params['userToken']
            ],
            [
                'expiresOn',
                '>=',
                $params['sqlTimestamp']
            ]
        ])->first();
            $result=$result?$result->toArray():[];
            return $result;
    }
}
