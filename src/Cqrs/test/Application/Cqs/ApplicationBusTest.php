<?php

declare(strict_types = 1);
namespace Com\Incoders\CqrsTest\Application\Cqs;

use PHPUnit\Framework\TestCase;
use DateTimeImmutable;
use Com\Incoders\Cqrs\Application\Cqs\ApplicationBus;
use Psr\Container\ContainerInterface;
use Com\Incoders\SampleMS\Domain\Command\SampleMS\SaveSampleMSCommand;
use Com\Incoders\SampleMS\Domain\Command\SampleMS\SaveSampleMSHandler;
use Com\Incoders\SampleMS\Domain\Query\SampleMS\SampleMSGetOneQuery;
use Com\Incoders\SampleMS\Domain\Query\SampleMS\SampleMSGetOneHandler;
use Com\Incoders\Cqrs\Application\Cqs\HandlerNotFoundException;

class ApplicationBusTest extends TestCase
{
    protected $container;

    protected $cmd;

    protected $query;


    public function setUp()
    {
        parent::setUp();

        $this->container = $this->getMockBuilder(ContainerInterface::class)
        ->disableOriginalConstructor()
        ->disableOriginalClone()
        ->disableArgumentCloning()
        ->disallowMockingUnknownTypes()
        ->getMock();

        $this->cmd=$this->getMockBuilder(SaveSampleMSCommand::class)
         ->disableOriginalConstructor()
        ->getMock();

        $this->query=$this->getMockBuilder(SampleMSGetOneQuery::class)
        ->disableOriginalConstructor()
        ->disableOriginalClone()
        ->disableArgumentCloning()
        ->disallowMockingUnknownTypes()
        ->getMock();
    }

    public function testCorrectClass()
    {
        $this->assertIsObject(new ApplicationBus($this->container));
    }
    public function testIstance()
    {
        $bus=new ApplicationBus($this->container);
        $this->assertIsObject($bus::instance($this->container));
    }

    public function testGetHandlerCmd()
    {
        $hdl=$this->getMockBuilder(SaveSampleMSHandler::class)
        ->disableOriginalConstructor()
        ->disableOriginalClone()
        ->disableArgumentCloning()
        ->disallowMockingUnknownTypes()
        ->getMock();
        $hdl->method('handle')->willReturn(true);
        $this->container->method('get')->willReturn($hdl);

        $bus=new ApplicationBus($this->container);
        $this->assertNull($bus->executeCommand($this->cmd));
    }

    public function testGetHandlerQuery()
    {
        $hdl=$this->getMockBuilder(SampleMSGetOneHandler::class)
        ->disableOriginalConstructor()
        ->disableOriginalClone()
        ->disableArgumentCloning()
        ->disallowMockingUnknownTypes()
        ->getMock();
        $this->container->method('get')->willReturn($hdl);

        $bus=new ApplicationBus($this->container);
        $this->expectException(HandlerNotFoundException::class);
        $bus->executeQuery($this->query);
    }// @codeCoverageIgnore

    public function testNotCorrectClass()
    {
        $cmd=$this->getMockBuilder(LocalCommand::class)
        ->disableOriginalConstructor()
        ->disableOriginalClone()
        ->disableArgumentCloning()
        ->disallowMockingUnknownTypes()
        ->getMock();

        $bus=new ApplicationBus($this->container);
        $this->expectExceptionMessage('Call to a member function handle() on null');
        $bus->executeCommand($cmd);
    }// @codeCoverageIgnore
}
use Com\Incoders\Cqrs\Application\Cqs\CommandInterface;

class LocalCommand implements CommandInterface
{
}
