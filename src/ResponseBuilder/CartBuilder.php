<?php

declare(strict_types=1);

namespace App\ResponseBuilder;

use App\Service\Cart\CartInterface;

class CartBuilder
{
    public function __invoke(CartInterface $cart): array
    {
        $data = [
            'total_price' => $cart->getTotalPrice(),
            'products' => [],
        ];

        foreach ($cart->getItems() as $item) {
            $data['products'][] = [
                'id' => $item->getId(),
                'productId' => $item->getProduct()->getId(),
                'name' => $item->getProduct()->getName(),
                'price' => $item->getPrice(),
                'quantity' => $item->getQuantity(),
            ];
        }

        return $data;
    }
}
