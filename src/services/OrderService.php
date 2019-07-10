<?php

namespace src\services;

use src\repositories\UserRepositoryInterface;
use src\repositories\ProductRepositoryInterface;
use src\repositories\OrderRepositoryInterface;
use src\models\entities\Order;
use src\models\dto\CreateOrderDto;
use src\models\dto\PayOrderDto;
use Symfony\Component\HttpClient\HttpClient;

/**
 * 
 */
class OrderService
{
    /**
     * @var \src\repositories\UserRepository
     */
    private $user_repository;

    /**
     * @var \src\repositories\ProductRepository
     */
    private $product_repository;

    /**
     * @var \src\repositories\OrderRepository
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
     * Создает объект заказа и сохраняет данные в БД
     * 
     * @return Order
     */
    public function create(CreateOrderDto $dto)
    {
        $products = $this->product_repository->findByIds($dto->product_ids);

        $user = $this->user_repository->findById($dto->user_id);
        if (!$user) {
            throw new \Exception('Пользователь с указаным идентификатором не найден');
        }

        $order = new Order(
            Order::generateGuid(),
            $user,
            new \DateTimeImmutable,
            $products
        );
        $this->order_repository->save($order);

        return $order;
    }

    /**
     * Производит оплату заказа
     * 
     * @return boolean
     * @throws \Exception
     */
    public function pay(PayOrderDto $dto)
    {
        $order = $this->order_repository->findById($dto->order_id);

        if (!$order) {
            throw new \Exception('Заказ с указаным идентификатором не найден');
        }

        if ($order->status_id != Order::STATUS_NEW) {
            throw new \Exception("Оплатить можно только заказы в статусе 'Новый");
        }

        if (!(abs($order->sum - $dto->amount) < 0.001 )) {
            throw new \Exception("Сумма заказа не совпадает с суммой оплаты");
        }

        $http_сlient = HttpClient::create();
        $response = $http_сlient->request('GET', 'http://ya.ru');
        $status_code = $response->getStatusCode();

        if ($status_code != 200) {
            throw new \Exception('Ошибка связи с платежной системой');
        }

        $order->changeStatus(Order::STATUS_PAID);
        $this->order_repository->updateStatus($order->id, Order::STATUS_PAID);

        return true;
    }
}
