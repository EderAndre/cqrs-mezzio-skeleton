<?php
declare(strict_types = 1);
namespace Com\Incoders\SampleMS\Infrastructure\Persistence\Repository\Entity;

use Illuminate\Database\Eloquent\Model as Eloquent;

class AuthClients extends Eloquent
{
    protected $table = 'xauth_clients';

    protected $primaryKey = 'name';

    const CREATED_AT = 'createdAt';

    const UPDATED_AT = 'updatedAt';

    protected $fillable = [
        'secret',
        'require_user_token',
        'app_consumer',
        'revoked',
        'createdAt',
        'updatedAt'
    ];
}
