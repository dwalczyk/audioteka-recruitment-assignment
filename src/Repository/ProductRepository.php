<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Product;
use App\Service\Catalog\ProductInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class ProductRepository implements ProductRepositoryInterface
{
    private EntityRepository $repository;

    public function __construct(private readonly EntityManagerInterface $em)
    {
        $this->repository = $this->em->getRepository(Product::class);
    }

    public function pagination(int $page = 1, int $count = 3): iterable
    {
        return $this->repository->createQueryBuilder('p')
            ->setMaxResults($count)
            ->setFirstResult(($page - 1) * $count)
            ->orderBy('p.createdAt', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function getTotalCount(): int
    {
        return $this->repository->createQueryBuilder('p')->select('count(p.id)')->getQuery()->getSingleScalarResult();
    }

    public function save(ProductInterface $product): void
    {
        if (!$this->em->contains($product)) {
            $this->em->persist($product);
        }

        $this->em->flush();
    }

    public function find(string $id): ?ProductInterface
    {
        return $this->repository->find($id);
    }

    public function remove(ProductInterface $product): void
    {
        $this->em->remove($product);
        $this->em->flush();
    }
}
