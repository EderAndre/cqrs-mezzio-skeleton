<?php
declare(strict_types = 1);
namespace Com\Incoders\SampleMSTest\Test\Application\Action\SampleMS;

use Com\Incoders\SampleMS\Application\Action\SampleMS\SampleMSGetOneHandler;
use Com\Incoders\SampleMS\Application\Action\SampleMS\SampleMSGetOneHandlerFactory;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Com\Incoders\Cqrs\Application\Cqs\ApplicationBus;

class SampleMSGetOneHandlerFactoryTest extends TestCase
{
    protected $container;

    protected function setUp()
    {
        $this->container = $this->prophesize(ContainerInterface::class);
    }

    public function testFactoryReturnCorrectType()
    {
        $factory = new SampleMSGetOneHandlerFactory();

        $this->container->has(ApplicationBus::class)->willReturn(true);

        $handler = $factory($this->container->reveal());

        $this->assertInstanceOf(SampleMSGetOneHandlerFactory::class, $factory);
        $this->assertInstanceOf(SampleMSGetOneHandler::class, $handler);
    }
}
