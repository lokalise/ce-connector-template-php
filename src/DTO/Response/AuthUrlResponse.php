<?php

namespace App\DTO\Response;

class AuthUrlResponse
{
    public function __construct(
        public readonly string $url,
    ) {
    }
}
