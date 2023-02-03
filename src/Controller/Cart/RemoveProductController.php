<?php

declare(strict_types=1);

namespace App\Controller\Cart;

use App\Entity\Cart;
use App\Entity\Product;
use App\Messenger\MessageBusAwareInterface;
use App\Messenger\MessageBusTrait;
use App\Messenger\RemoveProductFromCart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cart/{cart}/{product}', name: 'cart-remove-product', methods: ['DELETE'])]
class RemoveProductController extends AbstractController implements MessageBusAwareInterface
{
    use MessageBusTrait;

    public function __invoke(Cart $cart, ?Product $product): Response
    {
        if (null !== $product) {
            $this->dispatch(new RemoveProductFromCart($cart->getId(), $product->getId()));
        }

        return new Response(status: Response::HTTP_ACCEPTED);
    }
}
