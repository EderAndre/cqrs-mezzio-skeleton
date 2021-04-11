<?php
declare(strict_types = 1);
namespace Com\Incoders\SampleMSTest\Application\Actions\Enqueue;

use Com\Incoders\SampleMS\Domain\Service\ServiceFactory;
use PHPUnit\Framework\TestCase;
use ArrayObject;
use ErrorException;
use Exception;

class ServiceFactoryTest extends TestCase
{
    protected $genericService;

    protected function setUp()
    {
        $this->genericService = $this->createMock(ArrayObject::class);
    }

    public function testFactoryReturnCorrectType()
    {
        $service = ServiceFactory::useService(ArrayObject::class);
        $this->assertInstanceOf(ArrayObject::class, $service);
    }
    public function testFactoryReturnError()
    {
        $this->expectException(ErrorException::class);
            ServiceFactory::useService('ErrorObject');
    }// @codeCoverageIgnore
}
