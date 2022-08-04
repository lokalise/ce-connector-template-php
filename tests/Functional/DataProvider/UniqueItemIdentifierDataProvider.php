<?php

namespace App\Tests\Functional\DataProvider;

final class UniqueItemIdentifierDataProvider
{
    public const UNIQUE_ID = 'post:1:title';

    public const GROUP_ID = 'post:1';

    public const METADATA = [
        'contentType' => 'post',
        'field' => 'title',
    ];

    public const UNIQUE_ITEM_IDENTIFIER = [
        'uniqueId' => self::UNIQUE_ID,
        'groupId' => self::GROUP_ID,
        'metadata' => self::METADATA,
    ];
}
