<?php
declare(strict_types = 1);
namespace Com\Incoders\CqrsTest\Infrastructure\Persistence\EventStore;

use PHPUnit\Framework\TestCase;
use Com\Incoders\Cqrs\Infrastructure\Persistence\EventStore\PDOEventStore;
use Com\Incoders\Cqrs\Domain\Events\DomainEvents;
use Com\Incoders\Cqrs\Domain\Events\DomainModelEvent;
use Com\Incoders\Cqrs\Domain\Events\DomainEventInterface;
use Illuminate\Database\Capsule\Manager;
use DateTimeImmutable;

class PDOEventStoreTest extends TestCase
{

    protected $db;

    protected $pdo;

    public function setUp()
    {
        parent::setUp();

        $this->initDb();
        $this->pdo = new PDOEventStore();
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
        $importSql = file_get_contents(__DIR__ . '/../../../resources/database/dump_events.sql');
        $this->db->statement($importSql);
    }

    public function testCommit()
    {
        $ev = new LocalEvent(new \DateTimeImmutable(), 'content');
        $this->assertNull($this->pdo->commit(new DomainEvents([
            $ev
        ])));
    }

    public function testCommitBatch()
    {
        $ev = new LocalEvent(new \DateTimeImmutable(), 'content');
        $ev2 = new LocalEvent(new \DateTimeImmutable(), 'content2');
        $this->assertNull($this->pdo->commitBatch(new DomainEvents([
            $ev,
            $ev2
        ])));
    }
    public function testCommitBatchError()
    {
        $ev = new LocalEvent(new \DateTimeImmutable(), 'content');
        $ev2 = new LocalEvent(new \DateTimeImmutable(), 'content2');
        $this->assertNotNull($ev2->getOcurredOn());
        $this->assertNotNull($ev2->getName());

        $this->expectExceptionMessage('A DomainEvent muest be a DomainEventInterface istanceof');
        $d=new DomainEvents(['fail']);
    }// @codeCoverageIgnore
}

class LocalEvent extends DomainEvents implements DomainEventInterface
{
    private $ocurredOn;

    private $name;

    public function __construct(DateTimeImmutable $ocurredOn, String $name)
    {
        $this->ocurredOn = $ocurredOn;
        $this->name = $name;
    }

    public function getOcurredOn(): DateTimeImmutable
    {
        return $this->ocurredOn;
    }

    public function getName(): String
    {
        return $this->name;
    }

    public function jsonSerialize(): String
    {
        return json_encode([
            'name' => $this->name,
            'ocurredOn' => $this->ocurredOn
        ]);
    }
}
