<?php

namespace App\Exception;

final class ProductNotFoundException extends \Exception
{
    public function __construct(string $productId, ?\Throwable $previous = null)
    {
        parent::__construct(
            sprintf('Product [id: %s] does not found.', $productId),
            0,
            $previous
        );
    }
}