<?php

namespace tests\unit\entities\Order;

use Codeception\Test\Unit;
use src\entities\Order;
use src\entities\User;
use src\entities\Product;

class PayTest extends Unit
{
    public function testEmptyOrderCanNotBePaid()
    {
        $this->expectExceptionMessage('Пустой заказ не может быть оплачен');

        $user = new User(1, 'admin', 'password');
        $order = new Order($user);
        $order->setStatusPaid();
    }

    public function testOrderCanBePaid()
    {
        $user = new User(1, 'admin', 'password');
        $order = new Order($user);
        $product = new Product('Товар', 250.78);
        $order->addProduct($product);
        $order->setStatusPaid();

        $this->assertEquals($order->status_id, Order::STATUS_PAID);
    }
}
