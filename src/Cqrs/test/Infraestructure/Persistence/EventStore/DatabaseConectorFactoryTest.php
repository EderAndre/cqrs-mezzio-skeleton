<?php

declare(strict_types=1);

namespace Com\Incoders\CqrsTest\Infrastructure\Persistence\EventStore;

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

use Com\Incoders\Cqrs\Infrastructure\Persistence\EventStore\DatabaseConectorFactory;

class DatabaseConectorFactoryTest extends TestCase
{
    public function testFactory()
    {
        $cont = $this->getMockBuilder(ContainerInterface::class)
        ->disableOriginalConstructor()
        ->disableOriginalClone()
        ->disableArgumentCloning()
        ->disallowMockingUnknownTypes()
        ->getMock();
        $cont->method('get')->willReturn([
            'eloquent' => [
                'driver' => 'sqlite',
                'database' => ':memory:',
                'prefix' => '',
            ]
        ]);
        $db=new DatabaseConectorFactory($cont);
        $db->__invoke($cont);
        $this->assertIsObject($db);
    }
}
