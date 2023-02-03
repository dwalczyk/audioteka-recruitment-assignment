<?php

declare(strict_types=1);

namespace App\Controller\Catalog;

use App\Entity\Product;
use App\Messenger\MessageBusAwareInterface;
use App\Messenger\MessageBusTrait;
use App\Messenger\RemoveProductFromCatalog;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/products/{product}', name: 'product-delete', methods: ['DELETE'])]
class RemoveController extends AbstractController implements MessageBusAwareInterface
{
    use MessageBusTrait;

    public function __invoke(?Product $product): Response
    {
        if (null !== $product) {
            $this->dispatch(new RemoveProductFromCatalog($product->getId()));
        }

        return new Response(status: Response::HTTP_ACCEPTED);
    }
}
