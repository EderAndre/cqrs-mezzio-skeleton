<?php
declare(strict_types = 1);
namespace Com\Incoders\SampleMSTest\Application\Action\File;

use Com\Incoders\SampleMS\Application\Action\File\UploadFileHandler;
use Com\Incoders\SampleMS\Application\Action\File\UploadFileHandlerFactory;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Com\Incoders\Cqrs\Application\Cqs\ApplicationBus;

class UploadFileHandlerFactoryTest extends TestCase
{
    protected $container;

    protected function setUp()
    {
        $this->container = $this->prophesize(ContainerInterface::class);
    }

    public function testFactoryReturnCorrectType()
    {
        $factory = new UploadFileHandlerFactory();
        $this->container->has(ApplicationBus::class)->willReturn(true);

        $handler = $factory($this->container->reveal());

        $this->assertInstanceOf(UploadFileHandlerFactory::class, $factory);
        $this->assertInstanceOf(UploadFileHandler::class, $handler);
    }
}
