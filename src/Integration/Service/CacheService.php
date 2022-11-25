<?php

namespace App\Integration\Service;

use App\DTO\CacheItem;
use App\DTO\Identifier;
use App\DTO\IdentifiersList;
use App\Integration\DTO\AuthCredentials;
use App\Integration\DTO\CacheItemFields;
use App\Integration\DTO\ConnectorConfig;
use App\Integration\DTO\Metadata;
use App\Interfaces\Service\CacheServiceInterface;

class CacheService implements CacheServiceInterface
{
    /**
     * @return array<int, Identifier>
     */
    public function getCache(AuthCredentials $credentials, ConnectorConfig $connectorConfig): array
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
    public function getCacheItems(
        AuthCredentials $credentials,
        ConnectorConfig $connectorConfig,
        array $identifiers,
    ): IdentifiersList {
        return new IdentifiersList(
            array_map(
                static function (Identifier $translatableItem) {
                    $cacheItem = CacheItem::createFromIdentifier($translatableItem);
                    $cacheItem->title = 'title';
                    $cacheItem->groupTitle = 'groupTitle';
                    $cacheItem->fields = new CacheItemFields('id', new \DateTime());

                    return $cacheItem;
                },
                $identifiers,
            ),
        );
    }
}
