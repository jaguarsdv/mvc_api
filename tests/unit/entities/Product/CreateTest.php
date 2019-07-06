<?php

namespace tests\unit\entities\Product;

use Codeception\Test\Unit;
use src\entities\Product;

class CreateTest extends Unit
{
    public function testSuccess()
    {
        $product = new Product('Товар', 250.78);
 
        $this->assertNotNull($product->name);
        $this->assertNotNull($product->price);
        $this->assertEquals('Товар', $product->name);
        $this->assertEquals(250.78, $product->price);
    }

    public function testCildClassIdIsReadOnly()
    {
        $this->expectExceptionMessage('Setting read-only property: '
            . Product::class . '::$id'
        );
 
        $product = new Product('Товар', 250.78);
        $product->id = 3;
    }
}
