<?php
declare(strict_types = 1);
namespace Com\Incoders\SampleMSTest\Infrastructure\Persistence\Repository;

use PHPUnit\Framework\TestCase;
use Com\Incoders\SampleMS\Infrastructure\Persistence\Repository\AuthProtocolBufferCachedRepository;
use Illuminate\Database\Capsule\Manager;
use DateTime;
use DateInterval;

class AuthProtocolBufferCachedRepositoryTest extends TestCase
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
        $importSql = file_get_contents(__DIR__ . '/../../../resources/database/dump_xauthProtBuf.sql');
        $this->db->statement($importSql);
        $userBuffered = new AuthProtocolBufferCachedRepository();
        $userBuffered->id=1;
        $userBuffered->clientApiName = 'user_logged';
        $userBuffered->clientApiHashedKey = password_hash('secret', PASSWORD_DEFAULT);
        $userBuffered->userToken=1;
        $userBuffered->userInfoCached=json_encode(['userId'=>5]);

        $time = new DateTime();
        $time->add(new DateInterval('PT10M'));

        $userBuffered->expiresOn=$time;
        $userBuffered->save();
    }

    public function testFindAll()
    {
        $size = count(AuthProtocolBufferCachedRepository::findAll());
        $this->assertEquals($size, 1);
    }

    public function testFindById()
    {
        $this->assertNull(AuthProtocolBufferCachedRepository::findById('1000'));
    }
    public function testFindUnexpiratedProtocol()
    {
        $size = count(
            AuthProtocolBufferCachedRepository::findUnexpiratedProtocol(
                [
                    'clientApiName' => 'user_logged',
                    'userToken' => 1,
                    'sqlTimestamp' => new DateTime()
                ]
            )
        );
        $this->assertEquals($size, 8);
    }
}
