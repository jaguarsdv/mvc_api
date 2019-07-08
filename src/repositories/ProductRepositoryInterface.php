<?php

namespace src\repositories;

interface ProductRepositoryInterface
{
    public function getById(string $id);
    public function getByIds(array $ids);
}
