<?php
declare(strict_types = 1);
namespace Com\Incoders\SampleMS\Domain\Query\File;

use Com\Incoders\Cqrs\Application\Cqs\QueryHandlerInterface;
use Com\Incoders\Cqrs\Application\Cqs\QueryInterface;
use Com\Incoders\SampleMS\Infrastructure\Service\CloudStorage\BucketService;

class ListFilesHandler implements QueryHandlerInterface
{

    private $cloudStorageService;

    public function __construct(BucketService $cloudStorageService)
    {
        $this->cloudStorageService = $cloudStorageService;
    }

    public function handle(QueryInterface $query = null)
    {
//List files in directory example
        return $this->cloudStorageService->getFileList($query->params['preffix']);

//Download file /object
//$stream_result=$this->cloudStorageService->downloadFile('test/20200526132101_image.png');
//TODO:  work with this stream (byte array)
//Ex:
/*
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="'.basename('test/20200526132101_image.png').'"');
$stream_result=$this->cloudStorageService->downloadFile('test/20200526132101_image.png');
echo $stream_result;
*/
    }
}
