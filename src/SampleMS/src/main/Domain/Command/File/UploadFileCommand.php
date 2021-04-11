<?php
declare(strict_types = 1);
namespace Com\Incoders\SampleMS\Domain\Command\File;

use Com\Incoders\Cqrs\Application\Cqs\CommandInterface;

class UploadFileCommand implements CommandInterface
{

    private $name;

    private $fileStream;

    public function __construct($name, $fileStream)
    {
        $this->name = $name;
        $this->fileStream = $fileStream;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getFileStream()
    {
        return $this->fileStream;
    }
}
