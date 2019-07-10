<?php

namespace src\repositories;

interface UserRepositoryInterface
{
    public function findById(int $id);
}
