<?php

namespace App\DTO\Response;

class ApiErrorResponse
{
    public function __construct(
        public readonly int $code,
        public readonly string $message,
    ) {
    }
}
