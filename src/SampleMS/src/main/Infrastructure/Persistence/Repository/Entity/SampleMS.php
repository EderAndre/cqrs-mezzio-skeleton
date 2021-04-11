<?php
declare(strict_types = 1);
namespace Com\Incoders\SampleMS\Infrastructure\Persistence\Repository\Entity;

use Illuminate\Database\Eloquent\Model as Eloquent;

class SampleMS extends Eloquent
{
    protected $table = 'tb_sample';

    protected $primaryKey = 'id';

    const CREATED_AT = 'createdAt';

    const UPDATED_AT = 'updatedAt';

    protected $fillable = [
        'id',
        'condid',
        'name',
    ];
}
