<?php

namespace App\DTO\Response;

use App\DTO\Identifier;

class CacheResponse
{
    /**
     * @param array<int, Identifier> $items
     */
    public function __construct(
        public readonly array $items,
    ) {
    }
}
