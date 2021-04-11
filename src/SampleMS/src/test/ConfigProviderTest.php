<?php
declare(strict_types = 1);
namespace Com\Incoders\SampleMSTest;

use PHPUnit\Framework\TestCase;
use Com\Incoders\SampleMS\ConfigProvider;

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

    public function testGetTemplates()
    {
        $this->assertIsArray($this->configProvider->getTemplates());
    }
}
