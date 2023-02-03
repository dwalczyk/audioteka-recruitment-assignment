<?php

declare(strict_types=1);

namespace App\Messenger;

use App\Service\Cart\CartServiceInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class AddProductToCartHandler implements MessageHandlerInterface
{
    public function __construct(private readonly CartServiceInterface $service)
    {
    }

    public function __invoke(AddProductToCart $command): void
    {
        $this->service->addItem($command->cartId, $command->productId, $command->quantity);
    }
}
