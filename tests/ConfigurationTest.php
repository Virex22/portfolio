<?php

namespace App\Tests;

use App\Entity\Configuration;
use App\Helper\ConfigurationHelper;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

// test the configuration entity
class ConfigurationTest extends KernelTestCase
{

    public function testConfiguration()
    {
        $this->bootKernel();

        // get the configuration helper
        $configurationHelper = $this->getContainer()->get(ConfigurationHelper::class);

        // test the configuration helper
        $this->assertFalse($configurationHelper->existConfiguration('test'));
        $configurationHelper->setConfiguration('test', 'test');
        $this->assertTrue($configurationHelper->existConfiguration('test'));
        $this->assertEquals('test', $configurationHelper->getConfiguration('test'));
        $configurationHelper->removeConfiguration('test');
        $this->assertFalse($configurationHelper->existConfiguration('test'));
    }

    public function testConfigurationException()
    {
        $this->bootKernel();

        // get the configuration helper
        $configurationHelper = $this->getContainer()->get(ConfigurationHelper::class);

        // test the configuration helper
        $this->expectException(NotFoundResourceException::class);
        $configurationHelper->getConfiguration('test');
    }
}
