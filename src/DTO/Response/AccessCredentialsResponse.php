<?php

namespace App\DTO\Response;

class AccessCredentialsResponse
{
    public function __construct(
        public readonly string $accessToken,
        public readonly string $refreshToken,
        public readonly ?int $expiresIn = null,
    ) {
    }
}