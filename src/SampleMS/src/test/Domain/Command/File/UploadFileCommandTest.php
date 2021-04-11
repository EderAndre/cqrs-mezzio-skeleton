<?php
declare(strict_types = 1);
namespace Com\Incoders\SampleMSTest\Domain\Command\File;

use PHPUnit\Framework\TestCase;
use Com\Incoders\SampleMS\Domain\Command\File\UploadFileCommand;

class UploadFileCommandTest extends TestCase
{
    public $repository;
    public $cmd;

    protected function setUp()
    {


        $this->cmd = new UploadFileCommand('name', 'byte_array');

    }


    public function testgetNameDelete()
    {
        $this->assertEquals($this->cmd->getName(), 'name');
    }

    public function testDelete()
    {
        $this->assertEquals($this->cmd->getFileStream(), 'byte_array');
    }

}
