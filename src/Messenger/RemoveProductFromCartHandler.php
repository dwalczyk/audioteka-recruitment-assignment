<?php

declare(strict_types=1);

namespace App\Messenger;

use App\Service\Cart\CartServiceInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class RemoveProductFromCartHandler implements MessageHandlerInterface
{
    public function __construct(private readonly CartServiceInterface $service)
    {
    }

    public function __invoke(RemoveProductFromCart $command): void
    {
        $this->service->removeItem($command->cartId, $command->productId);
    }
}
