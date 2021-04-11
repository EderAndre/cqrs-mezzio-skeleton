<?php
declare(strict_types = 1);
namespace Com\Incoders\SampleMSTest\Application\Action\SpaceBooking;

use Com\Incoders\SampleMS\Application\Action\SampleMS\AddSampleMSHandler;
use Com\Incoders\SampleMS\Application\Action\SampleMS\AddSampleMSHandlerFactory;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Com\Incoders\Cqrs\Application\Cqs\ApplicationBus;

class AddSampleMSHandlerFactoryTest extends TestCase
{
    protected $container;

    protected function setUp()
    {
        $this->container = $this->prophesize(ContainerInterface::class);
    }

    public function testFactoryReturnCorrectType()
    {
        $factory = new AddSampleMSHandlerFactory();
        $this->container->has(ApplicationBus::class)->willReturn(true);

        $handler = $factory($this->container->reveal());

        $this->assertInstanceOf(AddSampleMSHandlerFactory::class, $factory);
        $this->assertInstanceOf(AddSampleMSHandler::class, $handler);
    }
}
