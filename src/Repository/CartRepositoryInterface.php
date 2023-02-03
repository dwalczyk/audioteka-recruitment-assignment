<?php

declare(strict_types=1);

namespace App\Repository;

use App\Service\Cart\CartInterface;

interface CartRepositoryInterface
{
    public function find(string $id): ?CartInterface;

    public function save(CartInterface $cart): void;
}
