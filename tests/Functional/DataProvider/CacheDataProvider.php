<?php

namespace App\Tests\Functional\DataProvider;

final class CacheDataProvider
{
    public const CACHE_RESPONSE = [
        'items' => [
            IdentifierDataProvider::UNIQUE_ITEM_IDENTIFIER,
        ],
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
                    'items' => array_map(
                        static fn(array $identifier) => array_merge($identifier, [
                            'fields' => $identifier['metadata'],
                            'title' => $identifier['uniqueId'] . $identifier['groupId'],
                        ]),
                        self::CACHE_ITEMS_REQUEST['items'],
                    ),
                ],
            ],
        ];
    }
}
