<?php

namespace App\Integration\DTO;

class AuthCredentials
{
    public function __construct(
        public readonly ?string $apiKey = null,
    ) {
    }
}
