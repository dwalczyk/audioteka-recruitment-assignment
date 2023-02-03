<?php

declare(strict_types=1);

namespace App\Messenger;

class AddProductToCatalog
{
    public function __construct(public readonly string $name, public readonly int $price)
    {
    }
}
