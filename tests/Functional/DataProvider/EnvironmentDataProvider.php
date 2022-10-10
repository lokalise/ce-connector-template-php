<?php

namespace App\Tests\Functional\DataProvider;

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
}
