<?php

namespace App\Interfaces\Service;

use App\DTO\CacheItem;
use App\DTO\Identifier;
use App\Exception\AccessDeniedException;
use App\Integration\DTO\AccessCredentials;

interface CacheServiceInterface
{
    /**
     * @return array<int, Identifier>
     *
     * @throws AccessDeniedException
     */
    public function getCache(AccessCredentials $credentials): array;

    /**
     * @param array<int, Identifier> $identifiers
     *
     * @return array<int, CacheItem>
     *
     * @throws AccessDeniedException
     */
    public function getCacheItems(AccessCredentials $credentials, array $identifiers): array;
}
