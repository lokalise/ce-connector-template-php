<?php

namespace App\Tests\Functional\DataProvider;

use App\Enum\ErrorCodeEnum;
use Symfony\Component\HttpFoundation\Response;

final class TranslationDataProvider
{
    public const TRANSLATION_REQUEST = [
        'defaultLocale' => 'en',
        'locales' => [
            EnvironmentDataProvider::LOCALE_CODE,
        ],
        'items' => [
            IdentifierDataProvider::UNIQUE_ITEM_IDENTIFIER,
        ],
    ];

    public static function translationRequestWithoutAuthHeaderProvider(): array
    {
        return [
            [
                self::TRANSLATION_REQUEST,
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

    public static function translationWithEmptyRequestProvider(): array
    {
        return [
            [
                [
                    'statusCode' => Response::HTTP_BAD_REQUEST,
                    'payload' => [
                        'errorCode' => ErrorCodeEnum::UNKNOWN_ERROR->value,
                        'details' => [
                            'errors' => [
                                [
                                    'defaultLocale' => ['This value should not be blank.'],
                                    'locales' => ['This value should not be blank.'],
                                    'items' => ['This value should not be blank.'],
                                ],
                            ],
                        ],
                        'message' => 'Bad request',
                    ],
                ],
            ],
        ];
    }

    public static function translationProvider(): array
    {
        return [
            [
                self::TRANSLATION_REQUEST,
                [
                    'items' => array_map(
                        static fn (array $identifier) => array_merge(
                            $identifier,
                            [
                                'translations' => array_combine(
                                    self::TRANSLATION_REQUEST['locales'],
                                    self::TRANSLATION_REQUEST['locales'],
                                ),
                            ],
                        ),
                        self::TRANSLATION_REQUEST['items'],
                    ),
                ],
            ],
        ];
    }
}
