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

    public const CACHE_ITEM_TITLE = 'title';

    public const CACHE_ITEM_GROUP_TITLE = 'groupTitle';

    public const CACHE_ITEM_FIELD_ID = 'id';

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
                        static fn(array $identifier) => array_merge(
                            $identifier,
                            [
                                'title' => self::CACHE_ITEM_TITLE,
                                'groupTitle' => self::CACHE_ITEM_GROUP_TITLE,
                                'fields' => [
                                    'id' => self::CACHE_ITEM_FIELD_ID,
                                ],
                            ]
                        ),
                        self::CACHE_ITEMS_REQUEST['items'],
                    ),
                ],
            ],
        ];
    }
}
