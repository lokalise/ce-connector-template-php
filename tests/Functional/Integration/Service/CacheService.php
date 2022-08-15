<?php

namespace App\Tests\Functional\Integration\Service;

use App\DTO\CacheItem;
use App\DTO\Identifier;
use App\Interfaces\Service\CacheServiceInterface;
use App\Tests\Functional\DataProvider\CacheDataProvider;
use App\Tests\Functional\DataProvider\IdentifierDataProvider;

class CacheService implements CacheServiceInterface
{
    /**
     * @return array<int, Identifier>
     */
    public function getCache(string $accessToken): array
    {
        $identifier = new Identifier();
        $identifier->uniqueId = IdentifierDataProvider::UNIQUE_ID;
        $identifier->groupId = IdentifierDataProvider::GROUP_ID;
        $identifier->metadata = IdentifierDataProvider::METADATA;

        return [$identifier];
    }

    /**
     * @param array<int, Identifier> $identifiers
     */
    public function getCacheItems(string $accessToken, array $identifiers): array
    {
        return array_map(static function (Identifier $translatableItem) {
            $cacheItem = CacheItem::createFromIdentifier($translatableItem);
            $cacheItem->title = CacheDataProvider::CACHE_ITEM_TITLE;
            $cacheItem->fields = $cacheItem->metadata;

            return $cacheItem;
        }, $identifiers);
    }
}
