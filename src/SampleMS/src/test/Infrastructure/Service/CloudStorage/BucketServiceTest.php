<?php
declare(strict_types = 1);
namespace Com\Incoders\SampleMSTest\Infrastructure\Service;

use PHPUnit\Framework\TestCase;
use Com\Incoders\Cqrs\Infrastructure\Persistence\EventStore\PDOEventStore;
use Google\Cloud\Storage\StorageClient;
use Com\Incoders\SampleMS\Infrastructure\Service\CloudStorage\BucketService;


class BucketServiceTest extends TestCase
{

    protected $service;
    protected function setUp()
    {

        $pdo = $this->createMock(PDOEventStore::class);

        $mockFunction=new class{
            function upload(){return true;}
            function objects(){
                return [
                    new class{function name(){return 'test/file.txt';}},
                    new class{function name(){return 'test/file2.txt';}}
                ];
                }
            function object(){
                return new class{
                    function delete(){return true;}
                    function downloadAsStream(){return new class{function getContents(){return true;}};}
            };
        }
        };
        $client = $this->createMock(StorageClient::class);
        $client->method('bucket')->willReturn($mockFunction);
        $this->service=new BucketService($client, 'bucketName',$pdo);
        
        $mockErrorFunction=new class{
            function upload(){throw new \Exception('Show error');}
            function objects(){
                return [
                    new class{function name(){return 'test/file.txt';}},
                    new class{function name(){return 'test/file2.txt';}}
                    ];
            }
            function object(){
                return new class{
                    function delete(){return true;}
                    function downloadAsStream(){return new class{function getContents(){return true;}};}
                };
            }
        };
        $clientError = $this->createMock(StorageClient::class);
        $clientError->method('bucket')->willReturn($mockErrorFunction);
        $this->serviceError=new BucketService($clientError, 'bucketName',$pdo);

        
        
    }

    public function testUpload()
    {
        $this->assertEquals($this->service->upload('content','test/file.txt'),'test/file.txt');
        $this->assertEquals($this->serviceError->upload('content','test/file.txt'),'_ERROR_:Show error');
    }

    public function testDelete()
    {
        $this->assertEquals(
            $this->service->delete('test/file.txt'),
            'Deleted gs://bucketName/test/file.txt'
        );
    }

    public function testGetList()
    {
        $this->assertEquals(
            count($this->service->getFileList('prefix')),2);
    }

    public function testDownload()
    {
        $this->assertTrue($this->service->downloadFile('test/file.txt'));
    }
}
