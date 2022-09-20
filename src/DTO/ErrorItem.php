<?php

namespace App\DTO;

class ErrorItem
{
    public function __construct(
        public readonly ?string $value,
        public readonly string $message,
        public readonly ?string $errorCode = null,
    ) {
    }
}
