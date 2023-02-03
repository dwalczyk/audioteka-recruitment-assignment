<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidType;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity]
class CartItem
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    private UuidInterface $id;

    #[ORM\ManyToOne(targetEntity: Cart::class, inversedBy: 'id')]
    private Cart $cart;

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'id')]
    private Product $product;

    #[ORM\Column(type: Types::INTEGER)]
    private int $price;

    #[ORM\Column(type: Types::INTEGER)]
    private int $quantity;

    public function __construct(string $id, Cart $cart, Product $product, int $price, int $quantity)
    {
        $this->id = Uuid::fromString($id);
        $this->cart = $cart;
        $this->product = $product;
        $this->price = $price;
        $this->quantity = $quantity;
    }

    public function getId(): string
    {
        return $this->id->toString();
    }

    public function getCart(): Cart
    {
        return $this->cart;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function updateQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }
}
