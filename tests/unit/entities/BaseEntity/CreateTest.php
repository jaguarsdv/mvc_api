<?php

namespace tests\unit\entities\BaseEntity;

use Codeception\Test\Unit;
use src\models\entities\BaseEntity;

class CreateTest extends Unit
{
    public function testBaseEntityCreationSuccess()
    {
        $base_entity = new BaseEntity(
            BaseEntity::generateGuid(),
            BaseEntity::TYPE_GUID_STR_36
        );
 
        $this->assertNotNull($base_entity->id);
        $this->assertEquals(1, preg_match(
            '/^[\da-f]{8}-[\da-f]{4}-[\da-f]{4}-[\da-f]{4}-[\da-f]{12}$/i',
            $base_entity->id
        ));
    }

    public function testBaseEntityIdIsReadOnly()
    {
        $this->expectExceptionMessage('Setting read-only property: '
            . BaseEntity::class . '::id'
        );
 
        $base_entity = new BaseEntity(
            BaseEntity::generateGuid(),
            BaseEntity::TYPE_GUID_STR_36
        );
        
        $base_entity->id = '4DB203C0-6B6E-44D5-B2C9-95DB6B143028';
    }
}
