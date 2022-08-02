<?php

namespace App\Tests\Integration\DataProvider;

abstract class PublishDataProvider extends UniqueItemIdentifierDataProvider
{
    public static function publishRequestParametersProvider(): array
    {
        $request = self::getItemsData([
            "translations" => [
                "de" => "Hallo Welt!",
            ],
        ]);

        $response = [
            "code" => "200",
            "message" => "Content successfully updated"
        ];

        return [
            [$request, $response],
        ];
    }
}
