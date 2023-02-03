<?php

declare(strict_types=1);

namespace App\Service\Cart;

use App\Entity\CartItem;

interface CartInterface
{
    public function getId(): string;

    public function getTotalPrice(): int;

    public function isFull(): bool;

    /**
     * @return CartItem[]
     */
    public function getItems(): iterable;

    public function getItemByProduct(string $productId): ?CartItem;

    public function addItem(CartItem $item): void;

    public function removeItem(CartItem $item): void;
}
