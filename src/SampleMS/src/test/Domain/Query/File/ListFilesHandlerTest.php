<?php
declare(strict_types = 1);
namespace Com\Incoders\SampleMSTest\Domain\Query\File;

use PHPUnit\Framework\TestCase;
use Com\Incoders\Cqrs\Application\Cqs\QueryInterface;
use Com\Incoders\SampleMS\Infrastructure\Service\CloudStorage\BucketService;
use Com\Incoders\SampleMS\Domain\Query\File\ListFilesHandler;
use Com\Incoders\SampleMS\Domain\Query\File\ListFilesQuery;


class ListFilesHandlerTest extends TestCase
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
        
        $service->method('getFileList')->willReturn([]);
        
        
        $this->handler = new ListFilesHandler($service);
    }
    
    public function testHandle()
    {
        $qry = $this->getMockBuilder(QueryInterface::class)
        ->disableOriginalConstructor()
        ->disableOriginalClone()
        ->disableArgumentCloning()
        ->disallowMockingUnknownTypes()
        ->getMock();
        $qry->params=['preffix'=>''];
        
        $result = $this->handler->handle($qry);
        $this->assertIsArray($result);
    }
}
