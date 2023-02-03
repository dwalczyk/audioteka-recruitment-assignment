<?php

declare(strict_types=1);

namespace App\Messenger;

class RemoveProductFromCart
{
    public function __construct(public readonly string $cartId, public readonly string $productId)
    {
    }
}
