<?php

namespace App\DTO\Response;

class RefreshResponse implements ResponseDTO
{
    public function __construct(
        public readonly string $apiKey,
    ) {
    }
}
