<?php

namespace App\DTO\Response;

use App\DTO\UniqueItemIdentifier;

class CacheResponse
{
    /**
     * @param array<int, UniqueItemIdentifier> $items
     */
    public function __construct(
        public readonly array $items,
    ) {
    }
}