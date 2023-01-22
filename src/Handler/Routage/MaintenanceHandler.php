<?php

namespace App\Handler\Routage;

use App\Helper\ConfigurationHelper;

class MaintenanceHandler
{
    private static $configurationKey = 'APP_MAINTENANCE';
    private $configurationHelper;

    public function __construct(ConfigurationHelper $configurationHelper)
    {
        $this->configurationHelper = $configurationHelper;
    }

    public function isInMaintenance(): bool
    {
        if ($this->configurationHelper->existConfiguration(self::$configurationKey))
            return $this->configurationHelper->getConfiguration(self::$configurationKey) === 'true';

        $this->configurationHelper->setConfiguration(self::$configurationKey, 'false');
        return false;
    }

}