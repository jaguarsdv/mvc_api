<?php

namespace src\services;

use src\repositories\ProductRepositoryInterface;

/**
 * 
 */
class ProductService
{
    /**
     * 
     */
    private $product_repository;

    /**
     * @param ProductRepositoryInterface $product_repository
     */
    public function __construct(
        ProductRepositoryInterface $product_repository
    ) {
        $this->product_repository = $product_repository;
    }

    /**
     * @return boolean
     */
    public function addDefaultProducts()
    {
        return $this->product_repository->addDefaultProducts();
    }

    /**
     * @return \src\models\entities\Product
     */
    public function findProduct(string $id)
    {
        return $this->product_repository->findById($id);
    }

    /**
     * @return \src\models\entities\Product
     */
    public function getAllProducts()
    {
        return $this->product_repository->getProductsList();
    }
}
