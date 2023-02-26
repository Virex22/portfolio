<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;

class EntityTest extends TestCase
{

    /**
     * implements this method like this :
     * yield [[
     *   'entity' => 'EntityName',
     *   'property' => 'value',
     *   'property2' => 'value2',
     *   'relation' => [
     *      'relationNamePlural' => 'relationNameSingular',
     *      'relationNamePlural2' => 'relationNameSingular2',
     *   ]
     */

    /**
     * @dataProvider provideEntities
     * @return \Generator
     */
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
            'relation' => [
                'skills' => 'skill',
            ]
        ]];
        yield [[
            'entity' => 'Experience',
            'company_name' => 'test',
            'start_date' => new \DateTime('2020-01-01'),
            'end_date' => new \DateTime('2020-01-01'),
            'post_name' => 'test',
            'compagny_logo' => 'test',
            'relation' => [
                'skills' => 'skill',
            ]
        ]];
        yield [[
            'entity' => 'Skill',
            'name' => 'test',
            'description' => 'test',
        ]];
        yield [[
            'entity' => 'Project',
            'name' => 'test',
            'description' => 'test',
            'content' => 'test',
            'relation' => [
                'skills' => 'skill',
            ]
        ]];
        yield [[
            'entity' => 'Skill',
            'name' => 'test',
            'description' => 'test',
            'badge' => 'test',
            'relation' => [
                'skillGroups' => 'skillGroup',
                'experiences' => 'experience',
                'projects' => 'project',
                'formations' => 'formation',
            ]
        ]];
        yield [[
            'entity' => 'SkillGroup',
            'custom_name' => 'test',
            'aquired_percentage' => 1,
            'priority' => 1,
            'relation' => [
                'skills' => 'skill',
            ]
        ]];
        yield [[
            'entity' => 'Configuration',
            'name' => 'test',
            'value' => 'test',
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
    public function testEntityGettersAndSetters(array $data): void
    {
        $entityName = 'App\\Entity\\' . $data['entity'];
        $entity = new $entityName();
        unset($data['entity']);
        foreach ($data as $property => $value) {
            if ($property === 'relation') {
                $this->testRelation($entity, $value);
                continue;
            }
            $property = $this->reformatProperty($property);
            $method = 'set' . ($property);
            $entity->$method($value);
            $method = 'get' . ucfirst($property);
            $this->assertEquals($value, $entity->$method());
        }
        $this->assertNull($entity->getId());
    }

    private function testRelation($entity, $value)
    {
        foreach ($value as $relationNamePlural => $relationNameSingular) {
            $this->addOrSetRelation($entity, $relationNameSingular);

            $gettedRelation = $this->getRelation($entity, $relationNamePlural, $relationNameSingular);

            if ($gettedRelation instanceof \Doctrine\Common\Collections\Collection) {
                $this->assertCount(1, $gettedRelation);
            }
            else {
                $this->assertInstanceOf('App\\Entity\\' . ucfirst($relationNameSingular), $gettedRelation);
            }

            $this->removeRelation($entity, $relationNameSingular);
        }
    }

    private function addOrSetRelation($entity, $relationNameSingular)
    {
        $method = 'add' . ucfirst($relationNameSingular);
        $relationName = 'App\\Entity\\' . ucfirst($relationNameSingular);
        if (method_exists($entity, $method)) {
            $entity->$method(new $relationName());
        }
        else {
            $method = 'set' . ucfirst($relationNameSingular);
            $entity->$method(new $relationName());
        }
    }

    private function getRelation($entity, $relationNamePlural, $relationNameSingular)
    {
        $method = 'get' . ucfirst($relationNamePlural);
        if (method_exists($entity, $method)) {
            return $entity->$method();
        }
        else {
            $method = 'get' . ucfirst($relationNameSingular);
            return $entity->$method();
        }
    }

    private function removeRelation($entity, $relationNameSingular)
    {
        $method = 'remove' . ucfirst($relationNameSingular);
        if (method_exists($entity, $method)) {
            $relationName = 'App\\Entity\\' . ucfirst($relationNameSingular);
            $entity->$method(new $relationName());
        }
    }
}
