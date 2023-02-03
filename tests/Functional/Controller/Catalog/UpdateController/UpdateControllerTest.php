<?php

namespace App\Tests\Functional\Controller\Catalog\UpdateController;

use App\Tests\Functional\WebTestCase;

class UpdateControllerTest extends WebTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->loadFixtures(new UpdateProductControllerFixture());
    }

    public function test_updates_product(): void
    {
        $this->client->request('PUT', '/products/0dbd0be2-161d-4dca-bb39-2b0a94711e9b', [
            'name' => 'Product name modified',
            'price' => 2990,
        ]);

        self::assertResponseStatusCodeSame(202);

        $this->client->request('GET', '/products');
        self::assertResponseStatusCodeSame(200);

        $response = $this->getJsonResponse();
        self::assertCount(1, $response['products']);
        self::assertequals('Product name modified', $response['products'][0]['name']);
        self::assertequals(2990, $response['products'][0]['price']);
    }

    public function test_product_with_empty_name_cannot_be_updated(): void
    {
        $this->client->request('PUT', '/products/0dbd0be2-161d-4dca-bb39-2b0a94711e9b', [
            'name' => '    ',
            'price' => 1990,
        ]);

        self::assertResponseStatusCodeSame(422);

        $response = $this->getJsonResponse();
        self::assertequals('Invalid name or price.', $response['error_message']);
    }

    public function test_product_without_a_price_cannot_be_updated(): void
    {
        $this->client->request('PUT', '/products/0dbd0be2-161d-4dca-bb39-2b0a94711e9b', [
            'name' => 'Product name',
        ]);

        self::assertResponseStatusCodeSame(422);

        $response = $this->getJsonResponse();
        self::assertequals('Invalid name or price.', $response['error_message']);
    }

    public function test_product_with_non_positive_price_cannot_be_updated(): void
    {
        $this->client->request('PUT', '/products/0dbd0be2-161d-4dca-bb39-2b0a94711e9b', [
            'name' => 'Product name',
            'price' => 0,
        ]);

        self::assertResponseStatusCodeSame(422);

        $response = $this->getJsonResponse();
        self::assertequals('Invalid name or price.', $response['error_message']);
    }
}