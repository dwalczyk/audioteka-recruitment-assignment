<?php

declare(strict_types=1);

namespace App\Entity;

use App\Service\Cart\CartInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidType;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity]
class Cart implements CartInterface
{
    public const CAPACITY = 3;

    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, nullable: false)]
    private UuidInterface $id;

    #[ORM\ManyToMany(targetEntity: CartItem::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinTable(name: 'cart_items')]
    private Collection $items;

    public function __construct(string $id)
    {
        $this->id = Uuid::fromString($id);
        $this->items = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id->toString();
    }

    public function getTotalPrice(): int
    {
        return \array_reduce(
            $this->items->toArray(),
            static fn (int $total, CartItem $item): int => $total + $item->getPrice(),
            0
        );
    }

    public function isFull(): bool
    {
        $totalItemsQuantity = \array_reduce(
            $this->items->toArray(),
            static fn (int $total, CartItem $item): int => $total + $item->getQuantity(),
            0
        );

        return $totalItemsQuantity >= self::CAPACITY;
    }

    /**
     * @throws \Exception
     *
     * @return CartItem[]
     */
    public function getItems(): iterable
    {
        return $this->items->getIterator();
    }

    public function getItemByProduct(string $productId): ?CartItem
    {
        foreach ($this->getItems() as $item) {
            if ($item->getProduct()->getId() === $productId) {
                return $item;
            }
        }

        return null;
    }

    public function addItem(CartItem $item): void
    {
        $this->items->add($item);
    }

    public function removeItem(CartItem $item): void
    {
        $this->items->removeElement($item);
    }
}
