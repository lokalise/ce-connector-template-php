<?php

namespace App\Tests\Functional\DataProvider;

final class TranslationDataProvider
{
    public const TRANSLATIONS = [
        [
            'uniqueId' => UniqueItemIdentifierDataProvider::UNIQUE_ID,
            'groupId' => UniqueItemIdentifierDataProvider::GROUP_ID,
            'metadata' => UniqueItemIdentifierDataProvider::METADATA,
            "translations" => [
                "en" => "en",
                "en_US" => "en_US",
                "ru" => "ru",
            ],
        ],
    ];

    public const TRANSLATION_REQUEST = [
        "locales" => [
            "en",
            "en_US",
            "ru",
        ],
        "items" => [
            UniqueItemIdentifierDataProvider::UNIQUE_ITEM_IDENTIFIER,
        ],
    ];

    public static function translationRequestProvider(): array
    {
        return [
            [self::TRANSLATION_REQUEST],
        ];
    }

    public static function translationProvider(): array
    {
        return [
            [
                self::TRANSLATION_REQUEST,
                [
                    "items" => self::TRANSLATIONS,
                ]
            ],
        ];
    }
}
