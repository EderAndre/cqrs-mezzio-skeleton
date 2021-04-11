<?php
declare(strict_types = 1);
namespace Com\Incoders\SampleMSTest\Domain\Command\File;

use PHPUnit\Framework\TestCase;
use Com\Incoders\SampleMS\Infrastructure\Service\CloudStorage\BucketService;
use Com\Incoders\SampleMS\Domain\Command\File\UploadFileHandler;
use Com\Incoders\SampleMS\Domain\Command\File\UploadFileCommand;

class UploadFileHandlerTest extends TestCase
{
    protected $handler;

    protected function setUp()
    {
        $service = $this->getMockBuilder(BucketService::class)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();

        $service->method('getFileList')->willReturn(true);


        $this->handler = new UploadFileHandler($service);
    }

    public function testHandle()
    {
        $cmd = $this->getMockBuilder(UploadFileCommand::class)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();

        $cmd->method('getFileStream')->willReturn('byte-array');
        $result = $this->handler->handle($cmd);
        $this->assertNull($result);
    }
}
