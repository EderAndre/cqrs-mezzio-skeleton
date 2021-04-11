<?php
declare(strict_types = 1);
namespace Com\Incoders\SampleMS\Infrastructure\Persistence\Repository;

use Com\Incoders\SampleMS\Infrastructure\Persistence\Repository\Entity\AuthClients;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class AuthClientsRepository extends AuthClients implements RepositoryInterface
{
    public function findAll(): LengthAwarePaginator
    {
        return AuthClientsRepository::paginate();
    }

    public function findById($id): ?AuthClients
    {
        return AuthClientsRepository::find($id);
    }
    public function findByClientName($name)
    {
        $auth = AuthClientsRepository::where([['name', '=', $name],['revoked', '=', 0]])->first();
        return $auth?$auth->toArray():[];
    }
    public function findBySecret($hashedSecret)
    {
        $auth = AuthClientsRepository::where('secret', '=', $hashedSecret)->where('revoked', '=', 0)->get();
        return $auth?$auth->toArray():[];
    }
}
