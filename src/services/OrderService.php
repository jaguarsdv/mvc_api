<?php

namespace src\services;

use src\repositories\UserRepositoryInterface;
use src\repositories\ProductRepositoryInterface;
use src\repositories\OrderRepositoryInterface;
use src\entities\Order;

/**
 * 
 */
class OrderService
{
    /**
     * 
     */
    private $user_repository;

    /**
     * 
     */
    private $product_repository;

    /**
     * 
     */
    private $order_repository;

    /**
     * @param UserRepositoryInterface $user_repository
     * @param ProductRepositoryInterface $product_repository
     * @param OrderRepositoryInterface $order_repository
     */
    public function __construct(
        UserRepositoryInterface $user_repository,
        ProductRepositoryInterface $product_repository,
        OrderRepositoryInterface $order_repository
    ) {
        $this->user_repository = $user_repository;
        $this->product_repository = $product_repository;
        $this->order_repository = $order_repository;
    }

    /**
     * 
     */
    public function create(array $product_ids, int $user_id)
    {
        $products = $this->product_repository->getByIds($product_ids);
        $user = $this->product_repository->getById($user_id);
        $order = new Order($user, $products);
        $this->product_repository->save($order);

        return $order;
    }

    /**
     * 
     */
    public function pay(string $order_id, float $sum)
    {
        $order = $this->order_repository->getById($order_id);
        if ($order->status_id == Order::STATUS_NEW
            && $order->sum == $sum
        ) {
            $response = 200;
            if ($response == 200) {
                $order->changeStatus(Order::STATUS_PAID);
                $this->product_repository->save($order);

                return true;
            }
        }

        return false;
    }
}
