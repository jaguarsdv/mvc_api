<?php

namespace tests\unit\entities\Product;

use Codeception\Test\Unit;
use src\models\entities\Product;

class CreateTest extends Unit
{
    public function testProductCreationSuccess()
    {
        $product = new Product(
            Product::generateGuid(),
            'Товар', 250.78,
            new \DateTimeImmutable
        );
 
        $this->assertNotNull($product->name);
        $this->assertNotNull($product->price);
        $this->assertEquals('Товар', $product->name);
        $this->assertEquals(250.78, $product->price);
    }

    public function testProductIdIsReadOnly()
    {
        $this->expectExceptionMessage('Setting read-only property: '
            . Product::class . '::id'
        );
 
        $product = new Product(
            Product::generateGuid(),
            'Товар', 250.78,
            new \DateTimeImmutable
        );
        $product->id = 3;
    }
}
