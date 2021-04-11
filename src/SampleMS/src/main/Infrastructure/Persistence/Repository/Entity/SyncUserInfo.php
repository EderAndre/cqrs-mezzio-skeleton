<?php
declare(strict_types = 1);
namespace Com\Incoders\SampleMS\Infrastructure\Persistence\Repository\Entity;

use Illuminate\Database\Eloquent\Model as Eloquent;

class SyncUserInfo extends Eloquent
{
    protected $table = 'tb_syncUserInfo';

    protected $primaryKey = 'userId';

    const CREATED_AT = 'createdAt';

    const UPDATED_AT = 'updatedAt';

    protected $fillable = [
        'userId',
        'displayName',
        'email',
        'emailNotification',
        'pushNotification',
        'smsNotification',
        'lastAccessOn',
        'createdAt',
        'updatedAt'
    ];
}
