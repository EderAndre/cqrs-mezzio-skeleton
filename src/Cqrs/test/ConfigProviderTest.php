<?php
declare(strict_types = 1);
namespace Com\Incoders\CqrsTest;

use PHPUnit\Framework\TestCase;
use Com\Incoders\Cqrs\ConfigProvider;

class ConfigProviderTest extends TestCase
{

    private $configProvider;

    protected function setUp()
    {
        parent::setUp();

        $this->configProvider = new ConfigProvider();
    }

    public function testInvoke()
    {
        $this->assertIsArray($this->configProvider->__invoke());
    }

    public function testGetDependencies()
    {
        $this->assertIsArray($this->configProvider->getDependencies());
    }
}
