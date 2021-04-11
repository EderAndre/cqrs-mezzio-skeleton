<?php
declare(strict_types = 1);
namespace Com\Incoders\SampleMSTest\Domain\Event;

use PHPUnit\Framework\TestCase;
use Com\Incoders\SampleMS\Domain\Event\FileUploaded;

class FileUploadedTest extends TestCase
{
    protected $obj;
    protected $date;

    protected function setUp()
    {
        $date = new \DateTimeImmutable;
        $this->date=$date;
        $this->obj = new FileUploaded($date, 'name');
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
