<?php

namespace App\Helper;

use App\Entity\Configuration;
use App\Repository\ConfigurationRepository;

class ConfigurationHelper
{
    private $configurationRepository;

    public function __construct(ConfigurationRepository $configurationRepository)
    {
        $this->configurationRepository = $configurationRepository;
    }

    public function getConfiguration(string $key, string $default = null): ?string
    {
        $configuration = $this->configurationRepository->findOneBy(['name' => $key]);

        return $configuration ? $configuration->getValue() : $default;
    }

    public function setConfiguration(string $key, string $value): void
    {
        $configuration = $this->configurationRepository->findOneBy(['name' => $key]);

        if (!$configuration) {
            $configuration = (new Configuration())
                ->setName($key);
        }

        $configuration->setValue($value);

        $this->configurationRepository->add($configuration, true);
    }
}