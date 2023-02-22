<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class RepositoryTest extends KernelTestCase
{

        public function provideEntities(): \Generator
        {
            yield [[
                'entity' => 'ContactMessage',
                'email' => 'test@test.test',
                'subject' => 'test',
                'message' => 'test',
                'name' => 'test',
            ]];
            yield [[
                'entity' => 'Service',
                'name' => 'test',
                'priority' => 1,
                'description' => 'test',
            ]];
            yield [[
                'entity' => 'Formation',
                'name' => 'test',
                'description' => 'test',
                'start_date' => new \DateTime('2020-01-01'),
                'end_date' => new \DateTime('2020-01-01'),
            ]];
            yield [[
                'entity' => 'Experience',
                'company_name' => 'test',
                'start_date' => new \DateTime('2020-01-01'),
                'end_date' => new \DateTime('2020-01-01'),
                'post_name' => 'test',
                'compagny_logo' => 'test',
            ]];
            yield [[
                'entity' => 'Skill',
                'name' => 'test',
                'description' => 'test',
                'badge' => 'test',
            ]];
            yield [[
                'entity' => 'Project',
                'name' => 'test',
                'description' => 'test',
                'content' => 'test',
            ]];
            yield [[
                'entity' => 'SkillGroup',
                'custom_name' => 'test',
                'aquired_percentage' => 1,
                'priority' => 1,
            ]];
        }

        private function reformatProperty(string $property): string
        {
            $property = str_replace('_', ' ', $property);
            $property = ucwords($property);
            $property = str_replace(' ', '', $property);
            return $property;
        }

        /**
         * @dataProvider provideEntities
         */
        public function testRepository(array $data)
        {
            $entity = $this->createEntity($data);
            $repository = $this->getRepository($data['entity']);
            $this->assertNotNull($repository);
            $this->assertNotNull($entity);
            $count = count($repository->findAll());
            $repository->add($entity, true);
            $this->assertEquals($count + 1, count($repository->findAll()));
            $repository->remove($entity, true);
            $this->assertEquals($count, count($repository->findAll()));
        }

        private function createEntity(array $data)
        {
            $entityName = 'App\Entity\\' . $data['entity'];
            $entity = new $entityName();
            unset($data['entity']);
            foreach ($data as $key => $value) {
                $method = 'set' . $this->reformatProperty($key);
                $entity->$method($value);
            }
            return $entity;
        }

        private function getRepository(string $entity)
        {
            self::$kernel = self::bootKernel();
            $entityManager = self::$kernel->getContainer()
                ->get('doctrine')
                ->getManager();
            return $entityManager->getRepository('App\Entity\\' . $entity);
        }

        private function getEntityManager()
        {
            return $this->getMockBuilder('Doctrine\ORM\EntityManager')
                ->disableOriginalConstructor()
                ->getMock();
        }
}
