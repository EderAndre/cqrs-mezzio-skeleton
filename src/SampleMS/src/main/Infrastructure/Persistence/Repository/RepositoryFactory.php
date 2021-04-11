<?php
namespace Com\Incoders\SampleMS\Infrastructure\Persistence\Repository;

abstract class RepositoryFactory
{

    const ERROREXCEPTIONCLASSNOTVALIDORM = "Class not is a valid eloquent model";

    const ERROREXCEPTIONCLASSNOTEXISTS = "Class not exists in this package";

    public static function useRepository($repositoryClassName)
    {
        if (! class_exists($repositoryClassName)) {
            throw new \ErrorException(self::ERROREXCEPTIONCLASSNOTEXISTS);
        } elseif (is_subclass_of(new $repositoryClassName(), 'Illuminate\Database\Eloquent\Model')) {
            return new $repositoryClassName();
        } else {
            throw new \ErrorException(self::ERROREXCEPTIONCLASSNOTVALIDORM);
        }
    }
}
