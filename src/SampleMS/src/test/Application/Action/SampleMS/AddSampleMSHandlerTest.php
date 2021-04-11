<?php
declare(strict_types = 1);
namespace Com\Incoders\SampleMSTest\Application\Action\SampleMS;

use Com\Incoders\SampleMS\Application\Action\SampleMS\AddSampleMSHandler;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Com\Incoders\Cqrs\Application\Cqs\ApplicationBus;
use Laminas\Diactoros\Response\JsonResponse;

class AddSampleMSHandlerTest extends TestCase
{
    protected $container;

    protected function setUp()
    {
        $this->container = $this->prophesize(ContainerInterface::class);
    }

    public function testReturnsJsonResponseWhenNoApplicationBusProvided()
    {
        $handler = $this->getMockBuilder(AddSampleMSHandler::class)
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
        $req->method('getQueryParams')->willReturn(['name'=>'Sample 1']);
        $req->method('getAttribute')->willReturn(new class{
            function getMatchedParams()
            {
                return [
                    'condid' => '1',
                ];
            }
        });

        $addHandler = new AddSampleMSHandler($bus);
        $response = $addHandler->handle($req);

        //$this->assertInstanceOf(AddSampleMSgHandler::class, $handler);
        $this->assertInstanceOf(AddSampleMSHandler::class, $addHandler);
        $this->assertInstanceOf(JsonResponse::class, $response);
    }
}
