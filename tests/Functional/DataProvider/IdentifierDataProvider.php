<?php

namespace App\Tests\Functional\DataProvider;

final class IdentifierDataProvider
{
    public const UNIQUE_ID = 'post_1_title';

    public const INVALID_UNIQUE_ID = 'invalid_unique_id';

    public const GROUP_ID = 'post_1';

    public const METADATA = [
        'contentType' => 'post',
        'field' => 'title',
    ];

    public const UNIQUE_ITEM_IDENTIFIER = [
        'uniqueId' => self::UNIQUE_ID,
        'groupId' => self::GROUP_ID,
        'metadata' => self::METADATA,
    ];

    public const INVALID_UNIQUE_ITEM_IDENTIFIER = [
        'uniqueId' => self::INVALID_UNIQUE_ID,
        'groupId' => self::GROUP_ID,
        'metadata' => self::METADATA,
    ];
}
