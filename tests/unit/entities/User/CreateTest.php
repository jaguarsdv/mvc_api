<?php

namespace tests\unit\entities\User;

use Codeception\Test\Unit;
use src\entities\User;

class CreateTest extends Unit
{
    public function testUserCreationSuccess()
    {
        $user = new User(1, 'admin', 'password');
 
        $this->assertEquals(1, $user->id);
        $this->assertEquals('admin', $user->login);
        $this->assertEquals('password', $user->password);
    }
}
