<?php

namespace src\services;

use src\repositories\ProductRepositoryInterface;

/**
 * 
 */
class OrderService
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
        $this->product_repository->addDefaultProducts();

        return true;
    }

}
