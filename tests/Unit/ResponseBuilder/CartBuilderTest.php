<?php

namespace App\Tests\Unit\ResponseBuilder;

use App\Entity\Cart;
use App\Entity\CartItem;
use App\Entity\Product;
use App\ResponseBuilder\CartBuilder;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\ResponseBuilder\CartBuilder
 */
class CartBuilderTest extends TestCase
{
    private CartBuilder $builder;

    protected function setUp(): void
    {
        parent::setUp();

        $this->builder = new CartBuilder();
    }

    public function test_builds_cart_with_no_products(): void
    {
        $cart = new Cart('3db5f857-e5a3-4c8d-a262-37da156c0001');

        $this->assertEquals([
            'total_price' => 0,
            'products' => []
        ], $this->builder->__invoke($cart));
    }

    public function test_builds_cart_with_products(): void
    {
        $cart = new Cart('3db5f857-e5a3-4c8d-a262-37da156c0001');
        $cart->addItem(new CartItem(
            '3afc1752-56ff-4829-808a-bfed2f216ba5',
            $cart,
            new Product('16e0226c-0ed8-434a-9342-429aefeb98f0', 'Product 1', 1990),
            1990,
            1
        ));
        $cart->addItem(new CartItem(
            'de10601a-695a-4e74-be0e-9ad3c7804386',
            $cart,
            new Product('5884ad4c-9ac2-40a5-ba11-1a96156c5889', 'Product 2', 3690),
            7380,
            2
        ));

        $this->assertEquals([
            'total_price' => 9370,
            'products' => [
                [
                    'id' => '3afc1752-56ff-4829-808a-bfed2f216ba5',
                    'productId' => '16e0226c-0ed8-434a-9342-429aefeb98f0',
                    'name' => 'Product 1',
                    'price' => 1990,
                    'quantity' => 1
                ],
                [
                    'id' => 'de10601a-695a-4e74-be0e-9ad3c7804386',
                    'productId' => '5884ad4c-9ac2-40a5-ba11-1a96156c5889',
                    'name' => 'Product 2',
                    'price' => 7380,
                    'quantity' => 2,
                ],
            ]
        ], $this->builder->__invoke($cart));
    }
}