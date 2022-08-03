<?php

namespace App\Tests\Functional\DataProvider;

final class CacheDataProvider
{
    public const CACHE_ITEMS = [
        [
            'uniqueId' => UniqueItemIdentifierDataProvider::UNIQUE_ID,
            'groupId' => UniqueItemIdentifierDataProvider::GROUP_ID,
            'metadata' => UniqueItemIdentifierDataProvider::METADATA,
            "fields" => UniqueItemIdentifierDataProvider::METADATA,
        ],
    ];

    public const CACHE_RESPONSE = [
        'items' => [UniqueItemIdentifierDataProvider::UNIQUE_ITEM_IDENTIFIER],
    ];

    public const CACHE_ITEMS_REQUEST = self::CACHE_RESPONSE;

    public static function cacheResponseProvider(): array
    {
        return [
            [self::CACHE_RESPONSE],
        ];
    }

    public static function cacheItemsRequestProvider(): array
    {
        return [
            [self::CACHE_ITEMS_REQUEST],
        ];
    }

    public static function cacheItemsProvider(): array
    {
        return [
            [
                self::CACHE_ITEMS_REQUEST,
                [
                    'items' => self::CACHE_ITEMS,
                ],
            ],
        ];
    }
}
