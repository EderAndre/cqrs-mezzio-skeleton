<?php
declare(strict_types = 1);
namespace Com\Incoders\CqrsTest\Application\Cqs;

use PHPUnit\Framework\TestCase;
use DateTimeImmutable;
use Com\Incoders\Cqrs\Application\Cqs\HandlerNotFoundException;

class HandlerNotFoundExceptionTest extends TestCase
{
    protected $container;

    protected $cmd;

    protected $query;


    public function setUp()
    {
        parent::setUp();
    }

    public function testExceptionThrow()
    {
        $except=new HandlerNotFoundException('IncorrectClass');
        $this->assertIsObject($except);
    }
}
