<?php

declare(strict_types = 1);

namespace Com\Incoders\SampleMSTest\Domain\Auth;

use Psr\Container\ContainerInterface;
use PHPUnit\Framework\TestCase;
use Com\Incoders\SampleMS\Domain\Auth\Client;

class ClientTest extends TestCase
{
    protected $deleteDefaulterListHandler;



    public function testHandle()
    {
        $client=new Client(true, false, 'ALLOW', 'access granted');

        $this->assertTrue($client->authenticated);
        $this->assertFalse($client->requestUserToken);
        $this->assertEquals($client->message, 'access granted');
        $this->assertEquals($client->status, 'ALLOW');
    }
}
