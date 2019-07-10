<?php

namespace tests\unit\entities\Order;

use Codeception\Test\Unit;
use src\models\entities\Order;
use src\models\entities\User;
use src\models\entities\Product;

class PayTest extends Unit
{
    public function testEmptyOrderCanNotBePaid()
    {
        $this->expectExceptionMessage('Пустой заказ не может быть оплачен');

        $user = new User(1, 'admin', 'password');
        $order = new Order(
            Order::generateGuid(),
            $user,
            new \DateTimeImmutable
        );
        $order->changeStatus(Order::STATUS_PAID);
    }

    public function testOrderCanBePaid()
    {
        $user = new User(1, 'admin', 'password');
        $order = new Order(
            Order::generateGuid(),
            $user,
            new \DateTimeImmutable
        );
        $product = new Product(
            Product::generateGuid(),
            'Товар',
            250.78,
            new \DateTimeImmutable,
        );
        $order->addProduct($product);
        $order->changeStatus(Order::STATUS_PAID);

        $this->assertEquals($order->status_id, Order::STATUS_PAID);
    }
}
