<?php

namespace App\Tests\Integration\DataProvider;

abstract class EnvironmentDataProvider
{
    const LOCALE_CODE = 'de';
    const LOCALE_NAME = 'German';
    const CACHE_ITEM_STRUCTURE = [
        "title" => "Title",
    ];

    /**
     * @dataProvider
     */
    public static function environmentResponseProvider(): array
    {
        return [
            [
                [
                    "items" => [
                        [
                            "defaultLocale" => self::LOCALE_CODE,
                            "locales" => [
                                [
                                    "name" => self::LOCALE_NAME,
                                    "code" => self::LOCALE_CODE,
                                ],
                            ],
                            "cacheItemStructure" => self::CACHE_ITEM_STRUCTURE,
                        ],
                    ],
                ]
            ],
        ];
    }
}