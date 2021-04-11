<?php
declare(strict_types = 1);
namespace Com\Incoders\SampleMSTest\Domain\Command\SampleMS;

use Psr\Container\ContainerInterface;
use PHPUnit\Framework\TestCase;
use Com\Incoders\Cqrs\Application\Cqs\CommandInterface;
use Com\Incoders\Cqrs\Infrastructure\Persistence\EventStore\PDOEventStore;
use Com\Incoders\SampleMS\Domain\Command\SampleMS\SaveSampleMSHandler;
use Com\Incoders\SampleMS\Domain\Command\SampleMS\SaveSampleMSCommand;
use Com\Incoders\SampleMS\Infrastructure\Persistence\Repository\SampleMSRepository;

class SaveSampleMSHandlerTest extends TestCase
{
    protected $saveAttachmentHandler;

    protected function setUp()
    {
        $attachmentRepositorio = $this->getMockBuilder(SampleMSRepository::class)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();

        $pdo = $this->createMock(PDOEventStore::class);

        $this->container = $this->getMockBuilder(ContainerInterface::class)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();
        $this->container->method('get')->willReturn([]);

        $this->saveAttachmentHandler = new SaveSampleMSHandler(
            $this->container,
            $attachmentRepositorio,
            $pdo
        );
    }

    public function testHandle()
    {
        $cmd=$this->getMockBuilder(SaveSampleMSCommand::class)
        ->disableOriginalConstructor()
        ->disableOriginalClone()
        ->disableArgumentCloning()
        ->disallowMockingUnknownTypes()
        ->getMock();
        $cmd->method('getSample')->willReturn(['id'=>null]);
        $result = $this->saveAttachmentHandler->handle($cmd);
        $this->assertNull($result);
    }
}
