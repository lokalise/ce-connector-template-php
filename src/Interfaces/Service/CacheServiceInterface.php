<?php

namespace App\Interfaces\Service;

use App\DTO\CacheItem;
use App\DTO\Identifier;
use App\Exception\AccessDeniedException;
use App\Integration\DTO\AuthCredential;

interface CacheServiceInterface
{
    /**
     * @return array<int, Identifier>
     *
     * @throws AccessDeniedException
     */
    public function getCache(AuthCredential $authCredential): array;

    /**
     * @param array<int, Identifier> $identifiers
     *
     * @return array<int, CacheItem>
     *
     * @throws AccessDeniedException
     */
    public function getCacheItems(AuthCredential $authCredential, array $identifiers): array;
}
