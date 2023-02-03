<?php

declare(strict_types=1);

namespace App\Service\Cart;

use App\Entity\Cart;
use App\Entity\CartItem;
use App\Exception\CartNotFoundException;
use App\Exception\ProductNotFoundException;
use App\Repository\CartRepositoryInterface;
use App\Repository\ProductRepositoryInterface;
use Ramsey\Uuid\Uuid;

class CartService implements CartServiceInterface
{
    public function __construct(
        private readonly CartRepositoryInterface $cartRepository,
        private readonly ProductRepositoryInterface $productRepository
    ) {
    }

    public function addItem(string $cartId, string $productId, int $quantity): CartItem
    {
        $cart = $this->cartRepository->find($cartId);
        $product = $this->productRepository->find($productId);

        if ($cart === null) {
            throw new CartNotFoundException($cartId);
        }

        if ($product === null) {
            throw new ProductNotFoundException($productId);
        }

        $cartItem = $cart->getItemByProduct($product->getId());

        if (null == $cartItem) {
            $cartItem = new CartItem(Uuid::uuid4()->toString(), $cart, $product, $product->getPrice(), $quantity);
        } else {
            $cartItem->updateQuantity($cartItem->getQuantity() + $quantity);
        }

        $cart->addItem($cartItem);
        $this->cartRepository->save($cart);

        return $cartItem;
    }

    public function removeItem(string $cartId, string $productId): void
    {
        $cart = $this->cartRepository->find($cartId);
        $product = $this->productRepository->find($productId);

        $cartItem = $cart->getItemByProduct($product->getId());
        if (null != $cartItem) {
            $cart->removeItem($cartItem);
            $this->cartRepository->save($cart);
        }
    }

    public function create(): CartInterface
    {
        $cart = new Cart(Uuid::uuid4()->toString());

        $this->cartRepository->save($cart);

        return $cart;
    }

    public function checkQuantities(CartInterface $cart): void
    {
        $quantity = 0;

        foreach ($cart->getItems() as $item) {
            $maxQuantity = Cart::CAPACITY - $quantity;

            if (0 === $maxQuantity) {
                $cart->removeItem($item);
                continue;
            }

            if ($maxQuantity !== $item->getQuantity()) {
                $item->updateQuantity(\min($item->getQuantity(), $maxQuantity));
            }

            $quantity += $item->getQuantity();
        }

        $this->cartRepository->save($cart);
    }
}
