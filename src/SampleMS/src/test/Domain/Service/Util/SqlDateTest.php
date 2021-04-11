<?php
declare(strict_types = 1);
namespace Com\Incoders\SampleMSTest\Domain\Service\Util;

use Com\Incoders\SampleMS\Domain\Service\Util\SqlDate;
use PHPUnit\Framework\TestCase;

class SqlDateTest extends TestCase
{

    protected $displayRaw;

    protected $displayColor;

    protected $displayColorStripLines;


    public function testReturnDateIsValid()
    {
        $sqlDate = new SqlDate();
        $this->assertTrue($sqlDate->dateIsValid('2020-01-01'));
    }
    public function testReturnDateNotIsValidBecauseUnformatted()
    {
        $sqlDate=new SqlDate();
        $this->assertFalse($sqlDate->dateIsValid('2020/01-02'));
        $this->assertFalse($sqlDate->dateIsValid('2020/01/30'));
    }
    public function testReturnDateNotIsValid()
    {
        $sqlDate=new SqlDate();
        $this->assertFalse($sqlDate->dateIsValid('2020-01-32'));
        $this->assertFalse($sqlDate->dateIsValid('2020-13-30'));
    }
    public function testReturnRangeNotIsValidBecauseDataFail()
    {
        $sqlDate = new SqlDate();
        $this->assertFalse($sqlDate->rangeIsValid('2020-01-32', '2020-02-15'));
        $this->assertFalse($sqlDate->rangeIsValid('2020-01-01', '2020-02-30'));
    }
    public function testReturnRangeNotIsValidBecauseIntervalNegative()
    {
        $sqlDate=new SqlDate();
        $this->assertFalse($sqlDate->rangeIsValid('2020-01-30', '2020-01-01'));
        $this->assertFalse($sqlDate->rangeIsValid('2020-01-01', '2019-02-30'));
    }
    public function testReturnRangeIsValid()
    {
        $sqlDate=new SqlDate();
        $this->assertTrue($sqlDate->rangeIsValid('2020-01-01', '2020-01-20'));
    }
}
