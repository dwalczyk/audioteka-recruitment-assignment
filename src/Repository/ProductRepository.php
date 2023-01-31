<?php

declare(strict_types=1);

namespace App\Repository;

use App\Service\Catalog\Product;
use App\Service\Catalog\ProductProvider;
use App\Service\Catalog\ProductService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Ramsey\Uuid\Uuid;

class ProductRepository implements ProductProvider, ProductService
{
    private EntityRepository $repository;

    public function __construct(private EntityManagerInterface $entityManager)
    {
        $this->repository = $this->entityManager->getRepository(\App\Entity\Product::class);
    }

    public function getProducts(int $page = 0, int $count = 3): iterable
    {
        return $this->repository->createQueryBuilder('p')
            ->setMaxResults($count)
            ->setFirstResult($page * $count)
            ->orderBy('p.createdAt', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function getTotalCount(): int
    {
        return $this->repository->createQueryBuilder('p')->select('count(p.id)')->getQuery()->getSingleScalarResult();
    }

    public function exists(string $productId): bool
    {
        return null !== $this->repository->find($productId);
    }

    public function add(string $name, int $price): Product
    {
        $product = new \App\Entity\Product(Uuid::uuid4()->toString(), $name, $price);

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        return $product;
    }

    public function remove(string $id): void
    {
        $product = $this->repository->find($id);
        if (null !== $product) {
            $this->entityManager->remove($product);
            $this->entityManager->flush();
        }
    }
}
