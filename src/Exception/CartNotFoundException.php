<?php

namespace App\Exception;

final class CartNotFoundException extends \Exception
{
    public function __construct(string $cartId, ?\Throwable $previous = null)
    {
        parent::__construct(
            sprintf('Cart [id: %s] does not found.', $cartId),
            0,
            $previous
        );
    }
}