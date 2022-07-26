<?php

namespace App\DTO\Response;

class RefreshResponse
{
    public function __construct(
        public readonly string $key,
    ) {
    }
}