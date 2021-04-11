<?php
declare(strict_types = 1);
namespace Com\Incoders\SampleMSTest\Domain\Command\File;

use Psr\Container\ContainerInterface;
use PHPUnit\Framework\TestCase;
use Com\Incoders\SampleMS\Domain\Command\File\UploadFileHandler;
use Com\Incoders\SampleMS\Domain\Command\File\UploadFileHandlerFactory;
use Com\Incoders\SampleMS\Infrastructure\Service\CloudStorage\BucketService;

class UploadFileHandlerFactoryTest extends TestCase
{

    public function testFactoryReturnCorrectType()
    {
        $service = $this->getMockBuilder(BucketService::class)
        ->disableOriginalConstructor()
        ->disableOriginalClone()
        ->disableArgumentCloning()
        ->disallowMockingUnknownTypes()
        ->getMock();

        $cont = $this->getMockBuilder(ContainerInterface::class)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();
            $cont->method('has')->willReturn(true);
            $cont->method('get')->willReturn($service);

        $factory = new UploadFileHandlerFactory();

        $handler = $factory($cont);

        $this->assertInstanceOf(UploadFileHandlerFactory::class, $factory);

        $this->assertInstanceOf(UploadFileHandler::class, $handler);
    }
}
