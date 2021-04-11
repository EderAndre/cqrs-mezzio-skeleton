<?php
declare(strict_types = 1);
namespace Com\Incoders\SampleMSTest\Infrastructure\Persistence\Repository;

use PHPUnit\Framework\TestCase;
use Com\Incoders\SampleMS\Infrastructure\Persistence\Repository\SyncUserInfoRepository;
use Illuminate\Database\Capsule\Manager;

class SyncUserInfoRepositoryTest extends TestCase
{

    protected $db;

    public function setUp()
    {
        parent::setUp();

        $this->initDb();
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
        $importSql = file_get_contents(__DIR__ . '/../../../resources/database/dump_tb_syncUserInfo.sql');
        $this->db->statement($importSql);
    }

    public function testFindAll()
    {
        $size = count(SyncUserInfoRepository::findAll());
        $this->assertEquals($size, 0);
    }

    public function testFindByUserId()
    {
        $this->assertNull(SyncUserInfoRepository::findById('undefined_name'));
    }
}
