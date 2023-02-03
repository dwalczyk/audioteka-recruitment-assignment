<?php

declare(strict_types=1);

namespace App\Controller\Cart;

use App\Entity\Cart;
use App\Entity\Product;
use App\Messenger\AddProductToCart;
use App\Messenger\MessageBusAwareInterface;
use App\Messenger\MessageBusTrait;
use App\ResponseBuilder\ErrorBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cart/{cart}/{product}', name: 'cart-add-product', methods: ['PUT'])]
class AddProductController extends AbstractController implements MessageBusAwareInterface
{
    use MessageBusTrait;

    public function __construct(private readonly ErrorBuilder $errorBuilder)
    {
    }

    public function __invoke(Cart $cart, Product $product): Response
    {
        if ($cart->isFull()) {
            return new JsonResponse(
                $this->errorBuilder->__invoke('Cart is full.'),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $this->dispatch(new AddProductToCart($cart->getId(), $product->getId(), 1));

        return new Response(status: Response::HTTP_ACCEPTED);
    }
}
