<?php

declare(strict_types=1);

namespace App\Service\Catalog;

interface ProductInterface
{
    public function getId(): string;

    public function getName(): string;

    public function getPrice(): int;

    public function getCreatedAt(): \DateTimeImmutable;

    public function updateName(string $name): void;

    public function updatePrice(int $price): void;
}
