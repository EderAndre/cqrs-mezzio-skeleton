<?php
declare(strict_types = 1);
namespace Com\Incoders\SampleMSTest\Application\Action\File;

use Com\Incoders\SampleMS\Application\Action\File\UploadFileHandler;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Com\Incoders\Cqrs\Application\Cqs\ApplicationBus;
use Laminas\Diactoros\Response\JsonResponse;

class UploadFileHandlerTest extends TestCase
{
    protected $container;

    protected function setUp()
    {
        $this->container = $this->prophesize(ContainerInterface::class);
    }

    public function testReturnsJsonResponseWhenNoApplicationBusProvided()
    {
        $handler = $this->getMockBuilder(UploadFileHandler::class)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();
        $handler->method('handle')->willReturn(true);

        $bus = $this->getMockBuilder(ApplicationBus::class)
            ->disableOriginalConstructor()
            ->getMock();
        $bus->method('executeCommand')->willReturn(true);

        $req = $this->getMockBuilder(ServerRequestInterface::class)->getMock();
        $req->method('getUploadedFiles')->willReturn(
            [
                'file'=>
                new class{
                    function getClientFilename(){return 'file.txt';}
                    function getStream(){return 'byte-content';}
                }
            ]
        );

        $addSpaceBookedHandler = new UploadFileHandler($bus);
        $response = $addSpaceBookedHandler->handle($req);

        $this->assertInstanceOf(UploadFileHandler::class, $handler);
        $this->assertInstanceOf(UploadFileHandler::class, $addSpaceBookedHandler);
        $this->assertInstanceOf(JsonResponse::class, $response);
    }
}
