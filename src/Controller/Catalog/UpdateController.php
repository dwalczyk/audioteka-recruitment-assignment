<?php

declare(strict_types=1);

namespace App\Controller\Catalog;

use App\Entity\Product;
use App\Messenger\MessageBusAwareInterface;
use App\Messenger\MessageBusTrait;
use App\Messenger\UpdateProduct;
use App\ResponseBuilder\ErrorBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/products/{product}', name: 'product-update', methods: ['PUT'])]
class UpdateController extends AbstractController implements MessageBusAwareInterface
{
    use MessageBusTrait;

    public function __construct(private readonly ErrorBuilder $errorBuilder)
    {
    }

    public function __invoke(?Product $product, Request $request): Response
    {
        $name = \trim($request->get('name'));
        $price = (int) $request->get('price');

        if ('' === $name || $price < 1) {
            return new JsonResponse(
                $this->errorBuilder->__invoke('Invalid name or price.'),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        if (null !== $product) {
            $this->dispatch(new UpdateProduct($product->getId(), $name, $price));
        }

        return new Response(status: Response::HTTP_ACCEPTED);
    }
}
