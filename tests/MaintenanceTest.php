<?php

namespace App\Tests;

use App\Handler\Routage\MaintenanceHandler;
use App\Helper\ConfigurationHelper;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MaintenanceTest extends WebTestCase
{

    public function testGoOnMaintenancePage(): void
    {
        $client = static::createClient();

        $configurationHelper = $this->getContainer()->get(ConfigurationHelper::class);

        $configurationHelper->setConfiguration(MaintenanceHandler::$configurationKey, 'true');
        $crawler = $client->request('GET', '/');

        $this->assertEquals(503, $client->getResponse()->getStatusCode());

        $this->assertSelectorExists('.maintenance-bloc');
    }

    public function testWithConfigurationNotSet(): void
    {
        $client = static::createClient();

        $configurationHelper = $this->getContainer()->get(ConfigurationHelper::class);

        $configurationHelper->removeConfiguration(MaintenanceHandler::$configurationKey);
        $crawler = $client->request('GET', '/');

        $this->assertNotEquals(503, $client->getResponse()->getStatusCode());

        $this->assertSelectorNotExists('.maintenance-bloc');
    }
}
