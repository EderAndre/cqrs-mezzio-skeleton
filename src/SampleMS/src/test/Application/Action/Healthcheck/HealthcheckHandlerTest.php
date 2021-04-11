<?php
declare(strict_types = 1);
namespace Com\Incoders\SampleMSTest\Application\Action\HealthCheck;

use Com\Incoders\SampleMS\Application\Action\Healthcheck\HealthcheckHandler;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Com\Incoders\Cqrs\Application\Cqs\ApplicationBus;
use Laminas\Diactoros\Response\JsonResponse;
use Illuminate\Database\Capsule\Manager;

class HealthCheckHandlerTest extends TestCase
{
    protected $container;
    protected function setUp()
    {
        $this->container = $this->prophesize(ContainerInterface::class);
        $this->initDb();

    }
    protected function initDb()
    {
        $capsule = new Manager();
        $capsule->addConnection([
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
        $this->db = $capsule->getDatabaseManager();
        
        // loading simple DB tables creation
        $importSql = file_get_contents(__DIR__ . '/../../../resources/database/dump_events.sql');
        $this->db->statement($importSql);
        $importSql = file_get_contents(__DIR__ . '/../../../resources/database/inject_events.sql');
        $this->db->statement($importSql);
    }

    public function testReturnsJsonResponseWhenNoApplicationBusProvided()
    {
        $handler = $this->getMockBuilder(HealthCheckHandler::class)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();
        $handler->method('handle')->willReturn(true);

        $req = $this->getMockBuilder(ServerRequestInterface::class)->getMock();

        $addAttachmentHandler = new HealthCheckHandler();
        $response = $addAttachmentHandler->handle($req);

        $this->assertInstanceOf(HealthCheckHandler::class, $handler);
        $this->assertInstanceOf(HealthCheckHandler::class, $addAttachmentHandler);
        $this->assertInstanceOf(JsonResponse::class, $response);
    }
}
