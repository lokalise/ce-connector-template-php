<?php

namespace App\Tests\Functional\Integration\Service;

use App\DTO\CacheItem;
use App\DTO\ErrorItem;
use App\DTO\Identifier;
use App\DTO\IdentifiersList;
use App\Integration\DTO\AuthCredentials;
use App\Integration\DTO\CacheItemFields;
use App\Integration\DTO\ConnectorConfig;
use App\Integration\DTO\Metadata;
use App\Interfaces\Service\CacheServiceInterface;
use App\Tests\Functional\DataProvider\CacheDataProvider;
use App\Tests\Functional\DataProvider\IdentifierDataProvider;

class CacheService implements CacheServiceInterface
{
    /**
     * @return array<int, Identifier>
     */
    public function getCache(AuthCredentials $credentials, ConnectorConfig $connectorConfig): array
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
    public function getCacheItems(
        AuthCredentials $credentials,
        ConnectorConfig $connectorConfig,
        array $identifiers,
    ): IdentifiersList {
        $validIdentifiers = array_filter(
            $identifiers,
            static fn (Identifier $identifier) => IdentifierDataProvider::UNIQUE_ID === $identifier->uniqueId,
        );
        $invalidIdentifiers = array_filter(
            $identifiers,
            static fn (Identifier $identifier) => IdentifierDataProvider::INVALID_UNIQUE_ID === $identifier->uniqueId,
        );

        return new IdentifiersList(
            array_map(
                static function (Identifier $translatableItem) {
                    $cacheItem = CacheItem::createFromIdentifier($translatableItem);
                    $cacheItem->title = CacheDataProvider::CACHE_ITEM_TITLE;
                    $cacheItem->groupTitle = CacheDataProvider::CACHE_ITEM_GROUP_TITLE;
                    $cacheItem->fields = new CacheItemFields(
                        CacheDataProvider::CACHE_ITEM_FIELD_ID,
                        \DateTime::createFromFormat(
                            'Y-m-d',
                            CacheDataProvider::CACHE_ITEM_FIELD_CREATED_AT,
                        ),
                    );

                    return $cacheItem;
                },
                $validIdentifiers,
            ),
            count($invalidIdentifiers) > 0 ? 'Some items were not published' : null,
            array_map(
                static fn (Identifier $identifier) => [
                    'uniqueId' => new ErrorItem($identifier->uniqueId, 'The field contains invalid characters'),
                ],
                $invalidIdentifiers,
            ),
        );
    }
}
