<?php

declare(strict_types=1);

namespace App\Service\Catalog;

interface ProductServiceInterface
{
    public function add(string $name, int $price): ProductInterface;

    public function remove(string $id): void;

    public function update(string $productId, string $name, int $price): ProductInterface;
}
