<?php
namespace Com\Incoders\SampleMS\Domain\Service;

abstract class ServiceFactory
{

    const ERROREXCEPTIONCLASSNOTEXISTS  = "Class not exists in this package";

    public static function useService($serviceClassName)
    {
        if (! class_exists($serviceClassName)) {
            throw new \ErrorException(self::ERROREXCEPTIONCLASSNOTEXISTS);
        } else {
            return new $serviceClassName();
        }
    }
}
