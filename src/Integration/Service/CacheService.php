<?php

namespace App\Integration\Service;

use App\DTO\CacheItem;
use App\DTO\Identifier;
use App\Interfaces\Service\CacheServiceInterface;

class CacheService implements CacheServiceInterface
{
    /**
     * @return array<int, Identifier>
     */
    public function getCache(string $accessToken): array
    {
        $identifier = new Identifier();
        $identifier->uniqueId = 'post:1:title';
        $identifier->groupId = 'post:1';
        $identifier->metadata = [
            'contentType' => 'post',
            'field' => 'title',
        ];

        return [$identifier];
    }

    /**
     * @param array<int, Identifier> $identifiers
     */
    public function getCacheItems(string $accessToken, array $identifiers): array
    {
        return array_map(static function (Identifier $translatableItem) {
            $cacheItem = CacheItem::createFromIdentifier($translatableItem);
            $cacheItem->title = 'title';
            $cacheItem->fields = $cacheItem->metadata;

            return $cacheItem;
        }, $identifiers);
    }
}
