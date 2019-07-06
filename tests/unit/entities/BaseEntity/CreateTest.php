<?php

namespace tests\unit\entities\BaseEntity;

use Codeception\Test\Unit;
use src\entities\BaseEntity;

class CreateStr36Test extends Unit
{
    public function testSuccess()
    {
        $base_entity = new BaseEntity(BaseEntity::TYPE_GUID_STR_36);
        $base_entity->id = '4DB203C0-6B6E-44D5-B2C9-95DB6B143028';
 
        $this->assertEquals('4DB203C0-6B6E-44D5-B2C9-95DB6B143028',
            $base_entity->getId()
        );
 
        $this->assertNotNull($base_entity->create_date);
        $this->assertNotNull($base_entity->update_date);
    }

    public function testWrongType()
    {
        $this->expectExceptionMessage('Неверный тип идентификатора');
 
        $base_entity = new BaseEntity(BaseEntity::TYPE_GUID_STR_36);
        $base_entity->id = 3;
    }
}
