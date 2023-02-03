<?php

declare(strict_types=1);

namespace App\Controller\Cart;

use App\Entity\Cart;
use App\ResponseBuilder\CartBuilder;
use App\Service\Cart\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cart/{cart}', name: 'cart-show', methods: ['GET'])]
class ShowCartController extends AbstractController
{
    public function __construct(
        private readonly CartBuilder $cartBuilder,
        private readonly CartService $cartService
    ) {
    }

    public function __invoke(Cart $cart): Response
    {
        if ($cart->isFull()) {
            $this->cartService->checkQuantities($cart);
        }

        return new JsonResponse($this->cartBuilder->__invoke($cart), Response::HTTP_OK);
    }
}
