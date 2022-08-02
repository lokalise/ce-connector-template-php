<?php

namespace App\DTO\Response;

use App\DTO\CacheItem;

class CacheItemsResponse
{
    /**
     * @param array<int, CacheItem> $items
     */
    public function __construct(
        public readonly array $items,
    ) {
    }
}
