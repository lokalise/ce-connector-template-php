<?php

namespace App\Integration\DTO;

class AuthCredential
{
    public function __construct(
        public readonly ?string $apiKey = null,
    ) {
    }
}
