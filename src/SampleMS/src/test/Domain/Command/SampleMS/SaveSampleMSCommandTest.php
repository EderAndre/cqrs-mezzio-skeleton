<?php
declare(strict_types = 1);
namespace Com\Incoders\SampleMSTest\Domain\Command\SampleMS;

use PHPUnit\Framework\TestCase;
use Com\Incoders\SampleMS\Domain\Command\SampleMS\SaveSampleMSCommand;
use Com\Incoders\SampleMS\Infrastructure\Persistence\Repository\SampleMSRepository;
use Illuminate\Database\Capsule\Manager;

class SaveSampleMSCommandTest extends TestCase
{
    public $repository;
    public $cmd;


    protected function setUp()
    {
        $this->initDb();
        $this->repository = new SampleMSRepository();

        $data = [

            'name'=>'teste'
        ];
        $this->cmd = new SaveSampleMSCommand('name',$data);
        
    }
    protected function initDb()
    {
        $capsule = new Manager();
        $capsule->addConnection([
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
        $this->db = $capsule->getDatabaseManager();
        
        // loading simple DB tables creation
        $importSql = file_get_contents(__DIR__ . '/../../../resources/database/dump_sampleMS.sql');
        $this->db->statement($importSql);
        $importSql = file_get_contents(__DIR__ . '/../../../resources/database/inject_sampleMS.sql');
        $this->db->statement($importSql);
    }

    public function testgetNameAdd()
    {
        $this->assertEquals($this->cmd->getName(), 'name');
    }

    public function testAdd()
    {
        $this->assertEquals($this->cmd->getSample()['id'], null);

    }

}
