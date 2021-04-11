<?php
declare(strict_types = 1);
namespace Com\Incoders\SampleMSTest\Domain\Query\SampleMS;

use Psr\Container\ContainerInterface;
use PHPUnit\Framework\TestCase;
use Com\Incoders\SampleMS\Domain\Query\SampleMS\SampleMSGetOneHandler;
use Com\Incoders\SampleMS\Domain\Query\SampleMS\SampleMSGetOneHandlerFactory;
use Com\Incoders\SampleMS\Infrastructure\Persistence\Repository\SampleMSRepository;

class SampleMSGetOneHandlerFactoryTest extends TestCase
{


    protected function setUp()
    {
        $repo = $this->getMockBuilder(SampleMSRepository::class)
        ->disableOriginalConstructor()
        ->disableOriginalClone()
        ->disableArgumentCloning()
        ->disallowMockingUnknownTypes()
        ->getMock();

        $this->listrepoHandler=new SampleMSGetOneHandler($repo);
    }

    public function testFactoryReturnCorrectType()
    {
        $cont = $this->getMockBuilder(ContainerInterface::class)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();
            $factory = new SampleMSGetOneHandlerFactory();

        $handler = $factory();

        $this->assertInstanceOf(SampleMSGetOneHandlerFactory::class, $factory);

        $this->assertInstanceOf(SampleMSGetOneHandler::class, $handler);
    }
}
