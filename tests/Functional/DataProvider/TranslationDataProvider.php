<?php

namespace App\Tests\Functional\DataProvider;

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
                    'items' => array_map(
                        static fn (array $identifier) => array_merge(
                            $identifier,
                            [
                                'translations' => array_combine(
                                    self::TRANSLATION_REQUEST['locales'],
                                    self::TRANSLATION_REQUEST['locales'],
                                ),
                            ]
                        ),
                        self::TRANSLATION_REQUEST['items'],
                    ),
                ],
            ],
        ];
    }
}
