<?php
declare(strict_types = 1);
namespace Com\Incoders\SampleMSTest\Application\Action\File;

use Com\Incoders\SampleMS\Application\Action\File\DirectoryListHandler;
use Com\Incoders\SampleMS\Application\Action\File\DirectoryListHandlerFactory;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Com\Incoders\Cqrs\Application\Cqs\ApplicationBus;

class DirectoryListHandlerFactoryTest extends TestCase
{
    protected $container;

    protected function setUp()
    {
        $this->container = $this->prophesize(ContainerInterface::class);
    }

    public function testFactoryReturnCorrectType()
    {
        $factory = new DirectoryListHandlerFactory();
        $this->container->has(ApplicationBus::class)->willReturn(true);

        $handler = $factory($this->container->reveal());

        $this->assertInstanceOf(DirectoryListHandlerFactory::class, $factory);
        $this->assertInstanceOf(DirectoryListHandler::class, $handler);
    }
}
