<?php

namespace src\repositories;

interface OrderRepositoryInterface
{
    public function findById(string $id);
}
