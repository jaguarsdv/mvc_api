<?php

namespace src\repositories;

use src\models\entities\User;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * @return User|null
     */
    public function getById(int $id)
    {
        if ($id == 1) {
            return new User(1, 'admin');
        }

        return null;
    }
}
