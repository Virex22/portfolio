<?php

namespace App\Service;

use App\Helper\ConfigurationHelper;
use App\Repository\ServiceRepository;
use App\Repository\SkillRepository;

class HomeService
{
    private $serviceRepository;
    private $configurationHelper;
    private $skillRepository;

    public function __construct(
        ServiceRepository $serviceRepository,
        SkillRepository $skillRepository,
        ConfigurationHelper $configurationHelper)
    {
        $this->serviceRepository = $serviceRepository;
        $this->skillRepository = $skillRepository;
        $this->configurationHelper = $configurationHelper;
    }

    public function getViewData(): array
    {
        $serviceCount = $this->configurationHelper->getConfiguration("HOME_DISPLAY_SERVICE_COUNT", 5);
        $services = $this->serviceRepository->findBy([], ['id' => 'DESC'], $serviceCount);
        $skills = $this->skillRepository->findBy([], ['id' => 'DESC']);

        return [
            'services' => $services,
            'skills' => $skills
        ];
    }

}