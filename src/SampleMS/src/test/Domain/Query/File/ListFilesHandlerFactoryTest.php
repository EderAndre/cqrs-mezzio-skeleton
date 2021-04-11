<?php
declare(strict_types = 1);
namespace Com\Incoders\SampleMSTest\Domain\Query\File;

use PHPUnit\Framework\TestCase;
use Com\Incoders\SampleMS\Domain\Query\File\ListFilesHandler;
use Com\Incoders\SampleMS\Domain\Query\File\ListFilesHandlerFactory;
use Com\Incoders\SampleMS\Infrastructure\Service\CloudStorage\BucketService;
use Psr\Container\ContainerInterface;

class ListFilesHandlerFactoryTest extends TestCase
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
        $factory = new ListFilesHandlerFactory();
        $handler = $factory($cont);

        $this->assertInstanceOf(ListFilesHandlerFactory::class, $factory);
        $this->assertInstanceOf(ListFilesHandler::class, $handler);
    }
}
