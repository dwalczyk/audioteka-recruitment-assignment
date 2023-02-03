<?php

declare(strict_types=1);

namespace App\Messenger;

use App\Service\Catalog\ProductServiceInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class UpdateProductHandler implements MessageHandlerInterface
{
    public function __construct(private readonly ProductServiceInterface $service)
    {
    }

    public function __invoke(UpdateProduct $command): void
    {
        $this->service->update($command->id, $command->name, $command->price);
    }
}
