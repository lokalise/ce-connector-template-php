<?php

namespace App\Tests\Integration\DataProvider;

abstract class UniqueItemIdentifierDataProvider
{
    const UNIQUE_ID = 'post:1:title';
    const GROUP_ID = 'post:1';
    const METADATA = [
        "contentType" => "post",
        "field" => "title",
    ];
    const UNIQUE_ITEM_IDENTIFIER = [
        "uniqueId" => self::UNIQUE_ID,
        "groupId" => self::GROUP_ID,
        "metadata" => self::METADATA,
    ];

    protected static function getItemsData(array $fields = []): array
    {
        return [
            "items" => [
                $fields ? array_merge(self::UNIQUE_ITEM_IDENTIFIER, $fields) : self::UNIQUE_ITEM_IDENTIFIER
            ]
        ];
    }
}
