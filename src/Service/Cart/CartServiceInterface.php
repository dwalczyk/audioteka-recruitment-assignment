<?php

declare(strict_types=1);

namespace App\Service\Cart;

use App\Entity\CartItem;

interface CartServiceInterface
{
    public function addItem(string $cartId, string $productId, int $quantity): CartItem;

    public function removeItem(string $cartId, string $productId): void;

    public function create(): CartInterface;
}
