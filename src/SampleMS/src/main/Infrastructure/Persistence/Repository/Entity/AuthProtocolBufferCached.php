<?php
declare(strict_types = 1);
namespace Com\Incoders\SampleMS\Infrastructure\Persistence\Repository\Entity;

use Illuminate\Database\Eloquent\Model as Eloquent;

class AuthProtocolBufferCached extends Eloquent
{
    protected $table = 'xauth_protocolBufferCached';

    protected $primaryKey = 'id';

    const CREATED_AT = 'createdAt';

    const UPDATED_AT = 'updatedAt';


    protected $fillable = [
        'clientApiName',
        'clientApiHashedKey',
        'userToken',
        'userInfoCached',
        'expiresOn',
        'createdAt',
        'updatedAt'
    ];
}
