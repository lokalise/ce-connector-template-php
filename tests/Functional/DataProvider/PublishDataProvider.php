<?php

namespace App\Tests\Functional\DataProvider;

final class PublishDataProvider
{
    public const PUBLISH_REQUEST = [
        'items' =>  [
            [
                'uniqueId' => UniqueItemIdentifierDataProvider::UNIQUE_ID,
                'groupId' => UniqueItemIdentifierDataProvider::GROUP_ID,
                'metadata' => UniqueItemIdentifierDataProvider::METADATA,
                "translations" => [
                    "de" => "Hallo Welt!",
                ],
            ],
        ],
    ];

    public static function publishRequestProvider(): array
    {
        return [
            [self::PUBLISH_REQUEST],
        ];
    }

    public static function publishProvider(): array
    {
        return [
            [
                self::PUBLISH_REQUEST,
                [
                    "code" => "200",
                    "message" => "Content successfully updated"
                ],
            ],
        ];
    }
}
