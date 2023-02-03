<?php

declare(strict_types=1);

namespace App\Messenger;

class UpdateProduct
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly int $price
    ) {
    }
}
