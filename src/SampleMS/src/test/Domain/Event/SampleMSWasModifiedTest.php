<?php
declare(strict_types = 1);
namespace Com\Incoders\SampleMSTest\Domain\Event;

use PHPUnit\Framework\TestCase;
use DateTimeImmutable;
use Com\Incoders\SampleMS\Domain\Event\SampleMSWasModified;

class SpaceBookingWasModifiedTest extends TestCase
{
    private $name;

    protected $obj;
    protected $date;

    protected function setUp()
    {
        $date=new \DateTimeImmutable;
        $this->date=$date;
        $this->obj = new SampleMSWasModified($date, 'name');
    }

    public function testGetOcurredOn()
    {
        $this->assertEquals($this->obj->getOcurredOn(), $this->date);
    }

    public function testGetName()
    {
        $this->assertEquals($this->obj->getName(), 'name');
    }

    public function testjsonSerialize()
    {
        $this->assertJson($this->obj->jsonSerialize());
    }
}
