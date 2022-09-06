<?php

namespace App\DTO\Response;

class AuthKeyResponse
{
    public function __construct(
        public readonly string $apiKey,
    ) {
    }
}
