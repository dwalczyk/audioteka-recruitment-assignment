<?php

declare(strict_types=1);

namespace App\ResponseBuilder;

class ErrorBuilder
{
    public function __invoke(string $message): array
    {
        return [
            'error_message' => $message,
        ];
    }
}
