<?php

namespace App\Integration\DTO;

class Metadata
{
    public function __construct(
        public readonly string $contentType,
        public readonly string $field,
    ) {
    }
}
