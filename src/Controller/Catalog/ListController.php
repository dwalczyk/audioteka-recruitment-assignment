<?php

declare(strict_types=1);

namespace App\Controller\Catalog;

use App\Repository\ProductRepositoryInterface;
use App\ResponseBuilder\ProductListBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('products', name: 'product-list', methods: ['GET'])]
class ListController extends AbstractController
{
    private const MAX_PER_PAGE = 3;

    public function __construct(
        private readonly ProductRepositoryInterface $productRepository,
        private readonly ProductListBuilder $productListBuilder
    ) {
    }

    public function __invoke(Request $request): Response
    {
        $page = \max(1, (int) $request->get('page', 1));

        $products = $this->productRepository->pagination($page, self::MAX_PER_PAGE);
        $totalCount = $this->productRepository->getTotalCount();

        return new JsonResponse(
            $this->productListBuilder->__invoke($products, $page, self::MAX_PER_PAGE, $totalCount),
            Response::HTTP_OK
        );
    }
}
