<?php

namespace App\Service;

use App\Helper\ConfigurationHelper;
use App\Repository\ProjectRepository;
use App\Repository\SkillRepository;

class RealizationService
{
    private $projectRepository;
    private $configurationHelper;

    public function __construct(ProjectRepository $projectRepository, ConfigurationHelper $configurationHelper)
    {
        $this->projectRepository = $projectRepository;
        $this->configurationHelper = $configurationHelper;
    }

    public function getViewData(): array
    {
        $pinnedProjectsCount = $this->configurationHelper->getConfiguration("APP_DISPLAY_PINNED_PROJECT_COUNT", 5);

        // TODO :  add priority to project
        $projects = $this->projectRepository->findBy([], [/*'priority' => 'DESC'*/]);
        // TODO :  add pinned to project
        $pinnedProjects = $this->projectRepository->findBy([/*'pinned' => true*/], [/*'priority' => 'DESC'*/], $pinnedProjectsCount);


        return [
            'projects' => $projects,
            'pinnedProjects' => $pinnedProjects
        ];
    }
}