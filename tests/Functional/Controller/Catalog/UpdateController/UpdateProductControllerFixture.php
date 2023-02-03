<?php

namespace App\Tests\Functional\Controller\Catalog\UpdateController;

use App\Entity\Product;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;

class UpdateProductControllerFixture extends AbstractFixture
{
    public function load(ObjectManager $manager): void
    {
        $product = new Product('0dbd0be2-161d-4dca-bb39-2b0a94711e9b', 'Product 1', 1990);
        $manager->persist($product);

        $manager->flush();
    }
}