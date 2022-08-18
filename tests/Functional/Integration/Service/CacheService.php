<?php

namespace App\Tests\Functional\Integration\Service;

use App\DTO\CacheItem;
use App\DTO\Identifier;
use App\Integration\DTO\AuthCredential;
use App\Integration\DTO\CacheItemFields;
use App\Integration\DTO\Metadata;
use App\Interfaces\Service\CacheServiceInterface;
use App\Tests\Functional\DataProvider\CacheDataProvider;
use App\Tests\Functional\DataProvider\IdentifierDataProvider;

class CacheService implements CacheServiceInterface
{
    /**
     * @return array<int, Identifier>
     */
    public function getCache(AuthCredential $authCredential): array
    {
        return [
            new Identifier(
                IdentifierDataProvider::UNIQUE_ID,
                IdentifierDataProvider::GROUP_ID,
                new Metadata(
                    IdentifierDataProvider::METADATA['contentType'],
                    IdentifierDataProvider::METADATA['field'],
                )
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
            $cacheItem->title = CacheDataProvider::CACHE_ITEM_TITLE;
            $cacheItem->fields = new CacheItemFields(CacheDataProvider::CACHE_ITEM_FIELD_ID);

            return $cacheItem;
        }, $identifiers);
    }
}
