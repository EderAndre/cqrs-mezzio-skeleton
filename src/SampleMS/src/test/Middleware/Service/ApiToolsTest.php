<?php

declare(strict_types = 1);

namespace Com\Incoders\SampleMSTest\Middleware\Service;

use Com\Incoders\SampleMS\Middleware\Service\ApiTools;
use PHPUnit\Framework\TestCase;

class ApiToolsTest extends TestCase
{
    public function testConsumer()
    {
        $api = new ApiTools();
        $content = $api->consumeExternalApi('http://google.com');
        $this->assertNotnull($content);
    }
}
