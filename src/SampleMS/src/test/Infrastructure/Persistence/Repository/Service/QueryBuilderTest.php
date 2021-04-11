<?php
declare(strict_types = 1);
namespace Com\Incoders\SampleMSTest\Infrastructure\Persistence\Repository\Service;

use PHPUnit\Framework\TestCase;
use Com\Incoders\SampleMS\Infrastructure\Persistence\Repository\AuthClientsRepository;
use Com\Incoders\SampleMS\Infrastructure\Persistence\Repository\Service\QueryBuilder;
use Com\Incoders\Cqrs\Application\Cqs\QueryInterface;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class QueryBuilderTest extends TestCase
{
    protected $query;
    protected $queryBuilder;
    protected $repository;
    protected $queryInterface;
    protected $lengthAwarePaginator;
    protected $pdo;
    protected $bus;

    public function setUp()
    {
        $this->initDb();

        $this->repository = new AuthClientsRepository();
        $this->repository = AuthClientsRepository::where('1', '=', '1');

        $this->query = $this->getMockBuilder(QueryInterface::class)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();

        $this->queryBuilder = new QueryBuilder();
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
        $importSql = file_get_contents(__DIR__ . '/../../../../resources/database/dump_xauthClient.sql');
        $this->db->statement($importSql);
        $this->repository = new AuthClientsRepository();
        $this->repository=AuthClientsRepository::where('1', '=', '1');
    }

    protected function createRepositoryFake()
    {
        return [
            'table' => 'xauth_clients',
            'timestamps' =>  null,
            'fillable' => ['secret','require_user_token','app_consumer','revoked','createdAt','updatedAt'],
            'connection' => null,
            'primaryKey' => 'name',
            'keyType' => 'int',
            'incrementing' => '1',
            'with' => [],
            'withCount' => [],
            'perPage' => 15,
            'exists' => null,
            'wasRecentlyCreated' => null,
            'attributes' => [],
            'original' => [],
            'changes' => [],
            'casts' => [],
            'dates' => [],
            'dateFormat' => null,
            'appends' => [],
            'dispatchesEvents' => [],
            'observables' => [],
            'relations' => [],
            'touches' => [],
            'hidden' => [],
            'visible' => [],
            'guarded' => ['*']
        ];
    }

    public function testSize()
    {
        $this->query->params = [
            'size' => '5'
        ];

        $this->assertInstanceOf(
            LengthAwarePaginator::class,
            $this->queryBuilder->filter(
                $this->query,
                $this->repository
            )
        );
    }

    public function testPage()
    {
        $this->query->params = [
            'page' => '1'
        ];

        $this->assertInstanceOf(
            LengthAwarePaginator::class,
            $this->queryBuilder->filter(
                $this->query,
                $this->repository
            )
        );
    }

    public function testEquals()
    {
        $this->query->params = [
            'id_equals' => '1'
        ];

        $this->assertInstanceOf(
            LengthAwarePaginator::class,
            $this->queryBuilder->filter(
                $this->query,
                $this->repository
            )
        );
    }

    public function testIn()
    {
        $this->query->params = [
            'id_in' => '[1,2,3]'
        ];

        $this->assertInstanceOf(
            LengthAwarePaginator::class,
            $this->queryBuilder->filter(
                $this->query,
                $this->repository
            )
        );
    }

    public function testGreaterThanLessThan()
    {
        $this->query->params = [
            'id_greaterThan' => '1',
            'id_lessThan' => '5'
        ];

        $this->assertInstanceOf(
            LengthAwarePaginator::class,
            $this->queryBuilder->filter(
                $this->query,
                $this->repository
            )
        );
    }

    public function testGreaterOrEqualThanLessOrEqualThan()
    {
        $this->query->params = [
            'id_greaterOrEqualThan' => '1',
            'id_lessOrEqualThan' => '5'
        ];

        $this->assertInstanceOf(
            LengthAwarePaginator::class,
            $this->queryBuilder->filter(
                $this->query,
                $this->repository
            )
        );
    }

    public function testYear()
    {
        $this->query->params = [
            'competence_year' => '2019'
        ];

        $this->assertInstanceOf(
            LengthAwarePaginator::class,
            $this->queryBuilder->filter(
                $this->query,
                $this->repository
            )
        );
    }

    public function testMonth()
    {
        $this->query->params = [
            'competence_month' => '01'
        ];

        $this->assertInstanceOf(
            LengthAwarePaginator::class,
            $this->queryBuilder->filter(
                $this->query,
                $this->repository
            )
        );
    }

    public function testContains()
    {
        $this->query->params = [
            'competence_contains' => '20'
        ];

        $this->assertInstanceOf(
            LengthAwarePaginator::class,
            $this->queryBuilder->filter(
                $this->query,
                $this->repository
            )
        );
    }

    public function testSort()
    {
        $this->query->params = [
            'sort' => ['condominiumBlockCompetenceId:desc'],
        ];

        $this->assertInstanceOf(
            LengthAwarePaginator::class,
            $this->queryBuilder->filter(
                $this->query,
                $this->repository
            )
        );
    }

    public function testSortIsEmpty()
    {
        $this->query->params = [
            'sort' => ['']
        ];

        $this->assertInstanceOf(
            LengthAwarePaginator::class,
            $this->queryBuilder->filter(
                $this->query,
                $this->repository
            )
        );
    }

    public function testQueryParamsEmpty()
    {
        $this->query->params = [];

        $this->assertInstanceOf(
            LengthAwarePaginator::class,
            $this->queryBuilder->filter(
                $this->query,
                $this->repository
            )
        );
    }

    public function testShouldBeColumnFalse()
    {
        $this->query->params = [
            'XXX_equals' => '1'
        ];

        $this->assertInstanceOf(
            LengthAwarePaginator::class,
            $this->queryBuilder->filter(
                $this->query,
                $this->repository
            )
        );
    }

    public function testShouldBeInvalidAttribute()
    {
        $this->query->params = [
            'XXX' => '1'
        ];

        $this->assertInstanceOf(
            LengthAwarePaginator::class,
            $this->queryBuilder->filter(
                $this->query,
                $this->repository
            )
        );
    }
}
