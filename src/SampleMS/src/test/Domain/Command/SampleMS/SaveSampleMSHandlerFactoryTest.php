<?php
declare(strict_types = 1);
namespace Com\Incoders\SampleMSTest\Domain\Command\SampleMS;

use Psr\Container\ContainerInterface;
use PHPUnit\Framework\TestCase;
use Com\Incoders\SampleMS\Domain\Command\SampleMS\SaveSampleMSHandler;
use Com\Incoders\SampleMS\Domain\Command\SampleMS\SaveSampleMSHandlerFactory;

class SaveSampleMSHandlerFactoryTest extends TestCase
{
    protected $container;

    protected function setUp()
    {
    }

    public function testFactoryReturnCorrectType()
    {
        $cont = $this->getMockBuilder(ContainerInterface::class)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();
        $cont->method('get')->willReturn([]);
        $factory = new SaveSampleMSHandlerFactory();

        $handler = $factory($cont);

        $this->assertInstanceOf(SaveSampleMSHandlerFactory::class, $factory);

        $this->assertInstanceOf(SaveSampleMSHandler::class, $handler);
    }
}
