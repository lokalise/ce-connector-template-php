<?php

namespace App\Tests\Functional\DataProvider;

use App\Enum\ErrorCodeEnum;
use Symfony\Component\HttpFoundation\Response;

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

    public const CACHE_ITEM_FIELD_CREATED_AT = '2022-10-07';

    public static function cacheResponseProvider(): array
    {
        return [
            [self::CACHE_RESPONSE],
        ];
    }

    public static function cacheWithoutAuthHeaderProvider(): array
    {
        return [
            [[
                'statusCode' => Response::HTTP_UNAUTHORIZED,
                'payload' => [
                    'errorCode' => ErrorCodeEnum::AUTH_FAILED_ERROR->value,
                    'details' => [
                        'error' => 'Invalid api key',
                    ],
                    'message' => 'Authorization failed',
                ],
            ]],
        ];
    }

    public static function cacheItemsRequestWithoutAuthHeaderProvider(): array
    {
        return [
            [
                self::CACHE_ITEMS_REQUEST,
                [
                    'statusCode' => Response::HTTP_UNAUTHORIZED,
                    'payload' => [
                        'errorCode' => ErrorCodeEnum::AUTH_FAILED_ERROR->value,
                        'details' => [
                            'error' => 'Invalid api key',
                        ],
                        'message' => 'Authorization failed',
                    ],
                ],
            ],
        ];
    }

    public static function cacheItemsWithEmptyRequestProvider(): array
    {
        return [
            [[
                'statusCode' => Response::HTTP_BAD_REQUEST,
                'payload' => [
                    'errorCode' => ErrorCodeEnum::UNKNOWN_ERROR->value,
                    'details' => [
                        'errors' => [[
                            'items' => ['This value should not be blank.'],
                        ]],
                    ],
                    'message' => 'Bad request',
                ],
            ]],
        ];
    }

    public static function invalidCacheItemsProvider(): array
    {
        return [
            [
                [
                    'items' => [
                        IdentifierDataProvider::INVALID_UNIQUE_ITEM_IDENTIFIER,
                    ],
                ],
                [
                    'items' => [],
                    'code' => Response::HTTP_MULTI_STATUS,
                    'errors' => [
                        [
                            'uniqueId' => [
                                'value' => IdentifierDataProvider::INVALID_UNIQUE_ID,
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    public static function cacheItemsProvider(): array
    {
        return [
            [
                self::CACHE_ITEMS_REQUEST,
                [
                    'items' => array_map(
                        static fn (array $identifier) => array_merge(
                            $identifier,
                            [
                                'title' => self::CACHE_ITEM_TITLE,
                                'groupTitle' => self::CACHE_ITEM_GROUP_TITLE,
                                'fields' => [
                                    'id' => self::CACHE_ITEM_FIELD_ID,
                                    'createdAt' => self::CACHE_ITEM_FIELD_CREATED_AT,
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
