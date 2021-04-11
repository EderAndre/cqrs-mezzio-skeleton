<?php

declare(strict_types = 1);

namespace Com\Incoders\SampleMSTest\Domain\Query\SampleMS;

use Com\Incoders\SampleMS\Domain\Query\SampleMS\SampleMSGetOneHandler;
use PHPUnit\Framework\TestCase;
use Com\Incoders\SampleMS\Infrastructure\Persistence\Repository\SampleMSRepository;
use Com\Incoders\Cqrs\Application\Cqs\QueryInterface;

class SampleMSGetOneHandlerTest extends TestCase
{
    protected $getSampleHandler;
    protected $queryInterface;

    public function setUp()
    {
        $repo = $this->getMockBuilder(SampleMSRepository::class)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();

            $this->getSampleHandler = new SampleMSGetOneHandler($repo);

        $query = $this->getMockBuilder(QueryInterface::class)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();

        $query->params = [
            'id_equals' => '1'
        ];
        $this->queryInterface = $query;
    }

    public function testHandle()
    {
        $this->assertNull($this->getSampleHandler->handle($this->queryInterface));
    }
}
