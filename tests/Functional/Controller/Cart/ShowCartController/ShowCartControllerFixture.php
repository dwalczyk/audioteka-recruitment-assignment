<?php

namespace App\Tests\Functional\Controller\Cart\ShowCartController;

use App\Entity\Cart;
use App\Entity\CartItem;
use App\Entity\Product;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;

class ShowCartControllerFixture extends AbstractFixture
{

    public function load(ObjectManager $manager): void
    {
        $products = [
            '49d3f185-d357-47d4-b955-09e40317e4ee' => new Product('fbcb8c51-5dcc-4fd4-a4cd-ceb9b400bff7', 'Product 1', 1990),
            '0575e6f1-5a80-458c-8ce6-ded01b51bdee' => new Product('9670ea5b-d940-4593-a2ac-4589be784203', 'Product 2', 3990),
            'f0fb56d6-7034-4808-829c-7f1a315a5cd5' => new Product('15e4a636-ef98-445b-86df-46e1cc0e10b5', 'Product 3', 4990),
        ];

        foreach ($products as $product) {
            $manager->persist($product);
        }

        $cart = new Cart('fab8f7c3-a641-43c1-92d3-ee871a55fa8a');

        foreach ($products as $uuid => $product) {
            $cart->addItem(new CartItem($uuid, $cart, $product, $product->getPrice(), 1));
        }

        $manager->persist($cart);

        $manager->flush();
    }
}