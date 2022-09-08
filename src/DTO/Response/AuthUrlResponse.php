<?php

namespace App\DTO\Response;

class AuthUrlResponse implements ResponseDTO
{
    public function __construct(
        public readonly string $url,
    ) {
    }
}
