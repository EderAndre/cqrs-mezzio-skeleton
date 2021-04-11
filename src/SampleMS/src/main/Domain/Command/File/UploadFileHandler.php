<?php
declare(strict_types = 1);
namespace Com\Incoders\SampleMS\Domain\Command\File;

use Com\Incoders\Cqrs\Application\Cqs\CommandHandlerInterface;
use Com\Incoders\Cqrs\Application\Cqs\CommandInterface;
use Com\Incoders\SampleMS\Infrastructure\Service\CloudStorage\BucketService;

class UploadFileHandler implements CommandHandlerInterface
{

    private $cloudStorageService;

    public function __construct(BucketService $cloudStorageService)
    {
        $this->cloudStorageService = $cloudStorageService;
    }

    public function handle(CommandInterface $command) :void
    {
//Upload example
        $result= $this->cloudStorageService->upload($command->getFileStream(), $command->getName());
  //TODO: $result variable contains gs://bucketname/${FullObjectname}, work whit this


//Delete  file /object
//$string_result=$this->cloudStorageService->delete('test/20200526133757_Teams_windows_x64.exe');
//TODO:  $string_result = "Deleted ${FullObjectname}"work with this string
    }
}
