<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Cart;
use App\Service\Cart\CartInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

final class CartRepository implements CartRepositoryInterface
{
    private readonly ObjectRepository $repository;

    public function __construct(private readonly EntityManagerInterface $em)
    {
        $this->repository = $em->getRepository(Cart::class);
    }

    public function find(string $id): ?CartInterface
    {
        return $this->repository->find($id);
    }

    public function save(CartInterface $cart): void
    {
        if (!$this->em->contains($cart)) {
            $this->em->persist($cart);
        }

        $this->em->flush();
    }
}
