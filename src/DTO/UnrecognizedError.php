<?php

namespace App\DTO;

class UnrecognizedError
{
    public function __construct(
        public readonly string $message,
    ) {
    }
}
