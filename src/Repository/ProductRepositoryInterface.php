<?php

declare(strict_types=1);

namespace App\Repository;

use App\Service\Catalog\ProductInterface;

interface ProductRepositoryInterface
{
    /**
     * @return ProductInterface[]
     */
    public function pagination(int $page = 1, int $count = 3): iterable;

    public function getTotalCount(): int;

    public function save(ProductInterface $product): void;

    public function find(string $id): ?ProductInterface;

    public function remove(ProductInterface $product): void;
}
