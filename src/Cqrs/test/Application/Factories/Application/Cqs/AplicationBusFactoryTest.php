<?php
declare(strict_types = 1);
namespace Com\Incoders\CqrsTest\Application\Factories\Application\Cqs;

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Com\Incoders\Cqrs\Application\Cqs\ApplicationBus;
use Com\Incoders\Cqrs\Application\Factories\Application\Cqs\ApplicationBusFactory;

class AplicationBusFactoryTest extends TestCase
{
    protected $container;

    protected function setUp()
    {
        $this->container = $this->prophesize(ContainerInterface::class);
    }

    public function testFactoryReturnCorrectType()
    {
        $factory = new ApplicationBusFactory();
        $this->container->has(ApplicationBus::class)->willReturn(true);

        $handler = $factory($this->container->reveal());

        $this->assertInstanceOf(ApplicationBusFactory::class, $factory);
        $this->assertInstanceOf(ApplicationBus::class, $handler);
    }
}
