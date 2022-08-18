<?php

namespace App\Integration\DTO;

class CacheItemFields
{
    public function __construct(
        public readonly string $id,
    ) {
    }
}
