<?php
declare(strict_types = 1);
namespace Com\Incoders\CqrsTest\Infrastructure\Persistence\Projections;

use PHPUnit\Framework\TestCase;
use Com\Incoders\Cqrs\Infrastructure\Persistence\Projections\BaseProjection;
use Com\Incoders\Cqrs\Domain\Events\DomainEvents;
use Com\Incoders\Cqrs\Domain\Events\DomainModelEvent;
use Com\Incoders\Cqrs\Domain\Events\DomainEventInterface;
use Illuminate\Database\Capsule\Manager;
use DateTimeImmutable;

class BaseProjectionTest extends TestCase
{

    private $baseProjection;

    protected function setUp()
    {
        parent::setUp();
        $this->initDb();

        $this->projection = new LocalProjection();
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
    public function testProject()
    {
        $ev = new LocalEvent(new \DateTimeImmutable(), 'content');
        $ev2 = new LocalEvent(new \DateTimeImmutable(), 'content2');


        $ret=$this->projection->project(new DomainEvents([
            $ev,$ev2
        ]));
        $this->assertNull($ret);
        $ev3 = new LocalEvent(new \DateTimeImmutable(), 'content');
        $this->assertNotNull($ev3->getOcurredOn());
        $this->assertNotNull($ev3->getName());
    }
}

class LocalProjection extends BaseProjection
{
    public function localEvent($event) : bool
    {
        return true;
    }
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
}
