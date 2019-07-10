<?php

namespace src\repositories;

interface ProductRepositoryInterface
{
    public function findById(string $id);
    public function findByIds(array $ids);
}
