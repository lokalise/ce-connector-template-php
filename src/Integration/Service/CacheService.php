<?php

namespace App\Integration\Service;

use App\DTO\CacheItem;
use App\DTO\UniqueItemIdentifier;
use App\Interfaces\ApiClientInterface;
use App\Interfaces\Mapper\CacheItemMapperInterface;
use App\Interfaces\Mapper\CacheMapperInterface;
use App\Interfaces\Service\CacheServiceInterface;

class CacheService implements CacheServiceInterface
{
    public function __construct(
        private readonly ApiClientInterface $apiClient,
        private readonly CacheMapperInterface $cacheMapper,
        private readonly CacheItemMapperInterface $cacheItemMapper,
    ) {
    }

    /**
     * @return array<int, UniqueItemIdentifier>
     */
    public function getCache(string $accessToken): array
    {
        $cache = $this->apiClient->getCache($accessToken);

        return array_map(
            fn (array $item) => $this->cacheMapper->mapArrayToCache($item),
            $cache,
        );
    }

    /**
     * @param array<int, UniqueItemIdentifier> $identifiers
     *
     * @return array<int, CacheItem>
     */
    public function getCacheItems(string $accessToken, array $identifiers): array
    {
        $items = array_map(
            static fn (UniqueItemIdentifier $identifier) => [
                'uniqueId' => $identifier->uniqueId,
                'groupId' => $identifier->groupId,
                'metadata' => $identifier->metadata,
            ],
            $identifiers,
        );

        $cacheItems = $this->apiClient->getCacheItems($accessToken, $items);

        return array_map(
            fn (array $cacheItem) => $this->cacheItemMapper->mapArrayToCacheItem($cacheItem),
            $cacheItems,
        );
    }
}
