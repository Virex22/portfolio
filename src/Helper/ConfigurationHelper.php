<?php

namespace App\Helper;

use App\Entity\Configuration;
use App\Repository\ConfigurationRepository;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class ConfigurationHelper
{
    private $configurationRepository;

    public function __construct(ConfigurationRepository $configurationRepository)
    {
        $this->configurationRepository = $configurationRepository;
    }

    /**
     * @param string $key
     * @return string
     * @throws NotFoundResourceException
     */
    public function getConfiguration(string $key): string
    {
        $configuration = $this->configurationRepository->findOneBy(['name' => $key]);

        if ($configuration instanceof Configuration)
            return $configuration->getValue();

        throw new NotFoundResourceException("Configuration with key $key not found");
    }

    /**
     * @param string $key
     * @param string $value
     * @return void
     */
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

    /**
     * @param string $key
     * @return bool
     */
    public function existConfiguration(string $key): bool
    {
        return $this->configurationRepository->findOneBy(['name' => $key]) instanceof Configuration;
    }
}