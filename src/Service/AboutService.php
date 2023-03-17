<?php

namespace App\Service;

use App\Repository\ExperienceRepository;
use App\Repository\FormationRepository;
use App\Repository\SkillGroupRepository;

class AboutService
{
    private $skillGroupRepository;
    private $formationRepository;
    private $experienceRepository;

    public function __construct(
        SkillGroupRepository $skillGroupRepository,
        FormationRepository $formationRepository,
        ExperienceRepository $experienceRepository)
    {
        $this->skillGroupRepository = $skillGroupRepository;
        $this->formationRepository = $formationRepository;
        $this->experienceRepository = $experienceRepository;
    }

    public function getViewData(): array
    {
        $skillGroups = $this->skillGroupRepository->findBy([], ['priority' => 'DESC']);
        $formations = $this->formationRepository->findBy([], ['start_date' => 'DESC']);
        $experiences = $this->experienceRepository->findBy([], ['start_date' => 'DESC']);

        return [
            'skillGroups' => $skillGroups,
            'formations' => $formations,
            'experiences' => $experiences
        ];
    }
}