<?php

namespace App\Integration;

use App\DTO\CacheItem;
use App\DTO\UniqueItemIdentifier;
use App\Interfaces\CacheInterface;

class CacheService implements CacheInterface
{
    /**
     * @return array<int, UniqueItemIdentifier>|null
     */
    public function listItems(string $accessToken): ?array
    {
        return [];
    }

    /**
     * @param array<int, UniqueItemIdentifier> $items
     *
     * @return array<int, CacheItem>|null
     */
    public function getItems(string $accessToken, array $items): ?array
    {
        return [];
    }
}