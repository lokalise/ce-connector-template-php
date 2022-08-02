<?php

namespace App\Interfaces;

use App\DTO\CacheItem;
use App\DTO\UniqueItemIdentifier;

interface CacheInterface
{
    /**
     * @return array<int, UniqueItemIdentifier>|null
     */
    public function listItems(string $accessToken): ?array;

    /**
     * @param array<int, UniqueItemIdentifier> $items
     *
     * @return array<int, CacheItem>|null
     */
    public function getItems(string $accessToken, array $items): ?array;
}
