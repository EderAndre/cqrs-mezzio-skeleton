<?php
declare(strict_types = 1);
namespace Com\Incoders\SampleMSTest\Application\Action\File;

use Com\Incoders\SampleMS\Application\Action\File\DirectoryListHandler;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Com\Incoders\Cqrs\Application\Cqs\ApplicationBus;
use Laminas\Diactoros\Response\JsonResponse;

class DirectoryListHandlerTest extends TestCase
{
    protected $container;

    protected function setUp()
    {
        $this->container = $this->prophesize(ContainerInterface::class);
    }

    public function testReturnsJsonResponseWhenNoApplicationBusProvided()
    {
        $handler = $this->getMockBuilder(DirectoryListHandler::class)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();
        $handler->method('handle')->willReturn(true);

        $bus = $this->getMockBuilder(ApplicationBus::class)
            ->disableOriginalConstructor()
            ->getMock();
        $bus->method('executeQuery')->willReturn(true);

        $req = $this->getMockBuilder(ServerRequestInterface::class)->getMock();
        $req->method('getQueryParams')->willReturn(['preffix'=> 'test']);

        $addSpaceBookedHandler = new DirectoryListHandler($bus);
        $response = $addSpaceBookedHandler->handle($req);

        $this->assertInstanceOf(DirectoryListHandler::class, $handler);
        $this->assertInstanceOf(DirectoryListHandler::class, $addSpaceBookedHandler);
        $this->assertInstanceOf(JsonResponse::class, $response);
    }
}
