<?php

namespace App\Integration\Service;

use App\DTO\CacheItem;
use App\DTO\Identifier;
use App\Integration\DTO\AuthCredential;
use App\Integration\DTO\CacheItemFields;
use App\Integration\DTO\Metadata;
use App\Interfaces\Service\CacheServiceInterface;

class CacheService implements CacheServiceInterface
{
    /**
     * @return array<int, Identifier>
     */
    public function getCache(AuthCredential $authCredential): array
    {
        return [
            new Identifier(
                'post:1:title',
                'post:1',
                new Metadata('post', 'title'),
            ),
        ];
    }

    /**
     * @param array<int, Identifier> $identifiers
     */
    public function getCacheItems(AuthCredential $authCredential, array $identifiers): array
    {
        return array_map(static function (Identifier $translatableItem) {
            $cacheItem = CacheItem::createFromIdentifier($translatableItem);
            $cacheItem->title = 'title';
            $cacheItem->fields = new CacheItemFields('id');

            return $cacheItem;
        }, $identifiers);
    }
}
