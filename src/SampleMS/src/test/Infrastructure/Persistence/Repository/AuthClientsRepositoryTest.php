<?php
declare(strict_types = 1);
namespace Com\Incoders\SampleMSTest\Infrastructure\Persistence\Repository;

use PHPUnit\Framework\TestCase;
use Com\Incoders\SampleMS\Infrastructure\Persistence\Repository\AuthClientsRepository;
use Illuminate\Database\Capsule\Manager;

class AuthClientsRepositoryTest extends TestCase
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
        $importSql = file_get_contents(__DIR__ . '/../../../resources/database/dump_xauthClient.sql');
        $this->db->statement($importSql);
        $importSql = file_get_contents(__DIR__ . '/../../../resources/database/inject_xauthClients.sql');
        $this->db->statement($importSql);
    }

    public function testFindAll()
    {
        $size = count(AuthClientsRepository::findAll());
        $this->assertEquals($size, 2);
    }

    public function testFindById()
    {
        $this->assertNull(AuthClientsRepository::findById('undefined_name'));
    }
    public function testFindByClientName()
    {
        $size = count(AuthClientsRepository::findByClientName('user_logged'));
        $this->assertEquals($size, 7);
    }
    public function testFindBySecret()
    {
        $size = count(AuthClientsRepository::
            findBySecret('$2y$10$OisobpgzDkJwxusRlM/2mu65MqBsPgw1RHvbTU3YsojSK7dFA8pju'));
        $this->assertEquals($size, 1);
    }
}
