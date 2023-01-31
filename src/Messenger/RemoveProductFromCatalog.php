<?php

declare(strict_types=1);

namespace App\Messenger;

class RemoveProductFromCatalog
{
    public function __construct(public readonly string $productId)
    {
    }
}
