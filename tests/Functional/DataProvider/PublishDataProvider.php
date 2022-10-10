<?php

namespace App\Tests\Functional\DataProvider;

use App\Enum\ErrorCodeEnum;
use Symfony\Component\HttpFoundation\Response;

final class PublishDataProvider
{
    public const PUBLISH_REQUEST = [
        'defaultLocale' => 'en',
        'items' => [
            [
                ...IdentifierDataProvider::UNIQUE_ITEM_IDENTIFIER,
                'translations' => [
                    'de' => 'Hallo Welt!',
                ],
            ],
        ],
    ];

    public static function publishRequestWithoutAuthHeaderProvider(): array
    {
        return [
            [
                self::PUBLISH_REQUEST,
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

    public static function publishProvider(): array
    {
        return [
            [
                self::PUBLISH_REQUEST,
                [
                    'code' => '200',
                    'message' => 'Content successfully updated',
                ],
            ],
        ];
    }

    public static function publishWithEmptyRequestProvider(): array
    {
        return [
            [[
                'statusCode' => Response::HTTP_BAD_REQUEST,
                'payload' => [
                    'errorCode' => ErrorCodeEnum::UNKNOWN_ERROR->value,
                    'details' => [
                        'errors' => [
                            [
                                'defaultLocale' => ['This value should not be blank.'],
                                'items' => ['This value should not be blank.'],
                            ],
                        ],
                    ],
                    'message' => 'Bad request',
                ],
            ]],
        ];
    }
}
