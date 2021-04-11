<?php
namespace Com\Incoders\SampleMS\Domain\Service\Util;

class SqlDate
{

    public static function rangeIsValid(string $sqlDateStart, string $sqlDateEnd)
    {
        $result = false;

        if (self::dateIsValid($sqlDateStart) && self::dateIsValid($sqlDateEnd)) {
            $result = $sqlDateStart <= $sqlDateEnd;
        }
        return $result;
    }

    public static function dateIsValid(string $sqlDate)
    {
        $result = false;

        if (preg_match('/^(\d{4})-([01]{1}\d{1})-([0123]{1}\d{1})$/', $sqlDate, $matches)) {
            if (checkdate((int) $matches[2], (int) $matches[3], (int) $matches[1])) {
                $result = true;
            }
        }
        return $result;
    }
}
