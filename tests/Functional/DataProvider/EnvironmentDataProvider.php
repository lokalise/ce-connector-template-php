<?php

namespace App\Tests\Functional\DataProvider;

use App\Enum\ErrorCodeEnum;
use Symfony\Component\HttpFoundation\Response;

final class EnvironmentDataProvider
{
    public const LOCALE_CODE = 'de';

    public const LOCALE_NAME = 'German';

    public const CACHE_ITEM_STRUCTURE = [
        'id' => 'ID',
        'createdAt' => 'Created',
    ];

    public const ENVIRONMENTS = [
        'defaultLocale' => self::LOCALE_CODE,
        'locales' => [
            [
                'name' => self::LOCALE_NAME,
                'code' => self::LOCALE_CODE,
            ],
        ],
        'cacheItemStructure' => self::CACHE_ITEM_STRUCTURE,
    ];

    public static function environmentResponseProvider(): array
    {
        return [
            [self::ENVIRONMENTS],
        ];
    }

    public static function environmentWithoutAuthHeaderProvider(): array
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
}
