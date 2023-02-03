<?php

declare(strict_types=1);

namespace App\Messenger;

use App\Service\Catalog\ProductServiceInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class RemoveProductFromCatalogHandler implements MessageHandlerInterface
{
    public function __construct(private readonly ProductServiceInterface $service)
    {
    }

    public function __invoke(RemoveProductFromCatalog $command): void
    {
        $this->service->remove($command->productId);
    }
}
