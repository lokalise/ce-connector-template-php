<?php

namespace App\Tests\Integration\DataProvider;

abstract class TranslationDataProvider extends UniqueItemIdentifierDataProvider
{
    /**
     * @dataProvider
     */
    public static function translationRequestParametersProvider(): array
    {
        $request = [
            "locales" => [
                "en",
                "en_US",
                "ru",
            ],
            "items" => [
                self::UNIQUE_ITEM_IDENTIFIER,
            ],
        ];

        $response = self::getItemsData([
            "translations" => [
                "en" => "en",
                "en_US" => "en_US",
                "ru" => "ru",
            ],
        ]);

        return [
            [$request, $response],
        ];
    }
}