<?php

namespace tests\unit\entities\Order;

use Codeception\Test\Unit;
use src\models\entities\Order;
use src\models\entities\User;
use src\models\entities\Product;

class CreateTest extends Unit
{
    public function testOrderCreationSuccess()
    {
        $user = new User(1, 'admin', 'password');
        $order = new Order($user);
 
        $this->assertNotNull($order->user);
        $this->assertTrue($order->user instanceof User);
        $this->assertEquals($user, $order->user);
        $this->assertNotNull($order->products);
        $this->assertEquals([], $order->products);
        $this->assertEquals(Order::STATUS_NEW, $order->status_id);
        $this->assertEquals(0, $order->sum);
    }

    public function testOrderAddingProduct()
    {
        $user = new User(1, 'admin', 'password');
        $order = new Order($user);
        $product = new Product('Товар', 250.78);
        $order->addProduct($product);
 
        $this->assertContains($product, $order->products);
        $this->assertEquals($product->price, $order->sum);
    }
}
