<?php

declare(strict_types=1);

namespace App\Service\Catalog;

use App\Entity\Product;
use App\Repository\ProductRepositoryInterface;
use Ramsey\Uuid\Uuid;

class ProductService implements ProductServiceInterface
{
    public function __construct(
        private readonly ProductRepositoryInterface $productRepository
    ) {
    }

    public function add(string $name, int $price): ProductInterface
    {
        $product = new Product(Uuid::uuid4()->toString(), $name, $price);

        $this->productRepository->save($product);

        return $product;
    }

    public function update(string $productId, string $name, int $price): ProductInterface
    {
        $product = $this->productRepository->find($productId);
        $product->updateName($name);
        $product->updatePrice($price);

        $this->productRepository->save($product);

        return $product;
    }

    public function remove(string $id): void
    {
        $product = $this->productRepository->find($id);

        $this->productRepository->remove($product);
    }
}
