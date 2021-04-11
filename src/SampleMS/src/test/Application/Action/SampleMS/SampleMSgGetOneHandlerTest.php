<?php
declare(strict_types = 1);
namespace Com\Incoders\SampleMSTest\Test\Application\Action\SampleMS;

use Com\Incoders\SampleMS\Application\Action\SampleMS\SampleMSGetOneHandler;
use Com\Incoders\SampleMS\Application\Action\SampleMS\SampleMSGetOneHandlerFactory;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Com\Incoders\Cqrs\Application\Cqs\ApplicationBus;
use Laminas\Diactoros\Response\JsonResponse;

class SampleMSGetOneHandlerTest extends TestCase
{
    protected $container;

    protected function setUp()
    {
        $this->container = $this->prophesize(ContainerInterface::class);
    }

    public function testReturnsJsonResponseWhenNoApplicationBusProvided()
    {
        $factory = new SampleMSGetOneHandlerFactory();

        $bus = $this->getMockBuilder(ApplicationBus::class)
            ->disableOriginalConstructor()
            ->getMock();
        $bus->method('executeCommand')->willReturn(true);

        $handler = $this->getMockBuilder(SampleMSGetOneHandler::class)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();
        $handler->method('handle')->willReturn(true);

        $attachmentGetOneHandler = new SampleMSGetOneHandler($bus);

        $this->assertInstanceOf(SampleMSGetOneHandler::class, $attachmentGetOneHandler);

        $response = $attachmentGetOneHandler->handle($this->prophesize(ServerRequestInterface::class)
              ->reveal());

        $this->assertInstanceOf(SampleMSGetOneHandlerFactory::class, $factory);
        $this->assertInstanceOf(SampleMSGetOneHandler::class, $attachmentGetOneHandler);
        $this->assertInstanceOf(JsonResponse::class, $response);
    }
}
