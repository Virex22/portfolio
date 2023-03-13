<?php

namespace App\DataFixtures;

use App\Entity\Configuration;
use App\Entity\ContactMessage;
use App\Entity\Experience;
use App\Entity\Formation;
use App\Entity\Project;
use App\Entity\Service;
use App\Entity\Skill;
use App\Entity\SkillGroup;
use App\Handler\Routage\MaintenanceHandler;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{

    private $faker;
    /**
     * @var array $skills
     * @example [
     *     [
     *       'skill' => Skill,
     *       'used' => bool
     *     ]
     * ]
     */
    private $skills = [];

    public function load(ObjectManager $manager): void
    {
        $this->faker = \Faker\Factory::create('fr_FR');

        $this->loadSkills($manager);
        $this->loadContactMessage($manager);
        $this->loadService($manager);
        $this->loadSkillGroups($manager);
        $this->loadExperience($manager);

        $this->loadProjects($manager);
        $this->loadFormation($manager);

        $this->loadConfiguration($manager);

        $manager->flush();
    }

    private function loadSkills(ObjectManager $manager)
    {
        for ($i = 0; $i < 25; $i++) {
            $skill = new Skill();
            $skill->setName($this->faker->word);
            $skill->setBadge($this->faker->imageUrl(100, 100, 'technologies', true, 'Faker'));
            $skill->setDescription($this->faker->paragraph(rand(1, 3), true));
            $manager->persist($skill);
            $this->skills[] = [
                'skill' => $skill,
                'used' => false
            ];
        }
    }

    private function loadContactMessage(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; $i++) {
            $contactMessage = new ContactMessage();
            $contactMessage->setEmail($this->faker->email);
            $contactMessage->setSubject($this->faker->sentence(3, true));
            $contactMessage->setMessage($this->faker->paragraph(3, true));
            $contactMessage->setName($this->faker->name);
            $manager->persist($contactMessage);
        }
    }

    private function loadService(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; $i++) {
            $service = new Service();
            $service->setName($this->faker->word);
            $service->setPriority(rand(1, 1000));
            $service->setDescription($this->faker->paragraph(rand(1, 3), true));
            $manager->persist($service);
        }
    }

    private function loadSkillGroups(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; $i++) {
            $skillGroup = new SkillGroup();
            $skillGroup->setCustomName($this->faker->word);
            $skillGroup->setPriority(rand(1, 1000));
            $skillGroup->setAquiredPercentage(rand(1, 100));
            $this->setSkillsRelation($skillGroup);
            $manager->persist($skillGroup);
        }
    }

    private function loadExperience(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; $i++) {
            $experience = new Experience();
            $experience->setStartDate($this->faker->dateTimeBetween('-5 years', '-1 years'));
            $experience->setEndDate($this->faker->dateTimeBetween('-1 years', 'now'));
            $experience->setCompanyName($this->faker->company);
            $experience->setCompagnyLogo($this->faker->imageUrl(100, 100, 'technologies', true, 'Faker'));
            $experience->setPostName($this->faker->jobTitle);
            $this->setSkillsRelation($experience);
            $manager->persist($experience);
        }
    }

    private function loadProjects(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; $i++) {
            $project = new Project();
            $project->setName($this->faker->word);
            $project->setDescription($this->faker->paragraph(rand(1, 3), true));
            $project->setContent($this->faker->paragraph(rand(5, 20), true));
            $this->setSkillsRelation($project);
            $manager->persist($project);
        }
    }

    private function loadFormation(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; $i++) {
            $formation = new Formation();
            $formation->setStartDate($this->faker->dateTimeBetween('-5 years', '-1 years'));
            $formation->setEndDate($this->faker->dateTimeBetween('-1 years', 'now'));
            $formation->setName($this->faker->company);
            $formation->setDescription($this->faker->paragraph(rand(1, 3), true));
            $this->setSkillsRelation($formation);
            $manager->persist($formation);
        }
    }

    private function loadConfiguration(ObjectManager $manager)
    {
        // Maintenance Configuration
        $maintenance = new Configuration();
        $maintenance->setName(MaintenanceHandler::$configurationKey);
        $maintenance->setValue('false');
        $manager->persist($maintenance);
    }

    private function resetSkills()
    {
        foreach ($this->skills as $key => $skill) {
            $this->skills[$key]['used'] = false;
        }
    }

    /**
     * @param $entity
     * @return void
     */
    private function setSkillsRelation($entity): void
    {
        $this->resetSkills();
        $notUsedSkills = array_filter($this->skills, function ($skill) {
            return $skill['used'] === false;
        });
        for ($j = 0; $j < rand(1, 2); $j++) {
            $skill = $notUsedSkills[array_rand($notUsedSkills)];
            $entity->addSkill($skill['skill']);
            $this->skills[array_search($skill, $this->skills)]['used'] = true;
        }
    }
}
