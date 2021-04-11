<?php
declare(strict_types = 1);
namespace Com\Incoders\SampleMSTest\Infrastructure\Persistence\Repository;

use PHPUnit\Framework\TestCase;
use Com\Incoders\SampleMS\Infrastructure\Persistence\Repository\RepositoryFactory;


use Exception;

class RepositoryFactoryTest extends TestCase
{

    protected $db;

    public function setUp()
    {
        parent::setUp();
    }

    public function testClassNOtExists()
    {
        $this->expectException(Exception::class);
        RepositoryFactory::useRepository('EntryTagRepositoryFake');
    }// @codeCoverageIgnore

    public function testClassIsNotModel()
    {
        $this->expectException(Exception::class);
        RepositoryFactory::useRepository(Exception::class);
    }// @codeCoverageIgnore
}
