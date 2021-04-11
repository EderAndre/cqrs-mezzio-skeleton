<?php
declare(strict_types = 1);
namespace Com\Incoders\SampleMSTest\Infrastructure\Service\CloudStorage\BucketService;

use PHPUnit\Framework\TestCase;
use Com\Incoders\SampleMS\Infrastructure\Service\CloudStorage\BucketServiceFactory;
use Com\Incoders\SampleMS\Infrastructure\Service\CloudStorage\BucketService;
use Psr\Container\ContainerInterface;

class BucketServiceFactoryTest extends TestCase
{
    
    public function testFactoryReturnCorrectType()
    {
        $container = $this->getMockBuilder(ContainerInterface::class)
        ->disableOriginalConstructor()
        ->disableOriginalClone()
        ->disableArgumentCloning()
        ->disallowMockingUnknownTypes()
        ->getMock();
        $container->method('get')->willreturn(['google-cloud-storage'=>['CLOUD_STORAGE_BUCKET'=>'bucketname']]);

        $service = $this->getMockBuilder(BucketService::class)
        ->disableOriginalConstructor()
        ->disableOriginalClone()
        ->disableArgumentCloning()
        ->disallowMockingUnknownTypes()
        ->getMock();
        
        $factory = new BucketServiceFactory();

        $handler = $factory($container);

        $this->assertInstanceOf(BucketServiceFactory::class, $factory);

        $this->assertInstanceOf(BucketService::class, $handler);
    }
}
