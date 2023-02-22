<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;

class EntityTest extends TestCase
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
        ]];
        yield [[
            'entity' => 'Project',
            'name' => 'test',
            'description' => 'test',
            'content' => 'test',
        ]];
        yield [[
            'entity' => 'Skill',
            'name' => 'test',
            'description' => 'test',
            'badge' => 'test',
        ]];
        yield [[
            'entity' => 'SkillGroup',
            'custom_name' => 'test',
            'aquired_percentage' => 1,
            'priority' => 1,
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
            $property = $this->reformatProperty($property);
            $method = 'set' . ($property);
            $entity->$method($value);
            $method = 'get' . ucfirst($property);
            $this->assertEquals($value, $entity->$method());
        }
        $this->assertNull($entity->getId());
    }
}
