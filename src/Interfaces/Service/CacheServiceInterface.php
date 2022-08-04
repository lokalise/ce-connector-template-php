<?php

namespace App\Interfaces\Service;

use App\DTO\CacheItem;
use App\DTO\Identifier;
use App\Exception\AccessDeniedException;

interface CacheServiceInterface
{
    /**
     * @return array<int, Identifier>
     *
     * @throws AccessDeniedException
     */
    public function getCache(string $accessToken): array;

    /**
     * @param array<int, Identifier> $identifiers
     *
     * @return array<int, CacheItem>
     *
     * @throws AccessDeniedException
     */
    public function getCacheItems(string $accessToken, array $identifiers): array;
}
