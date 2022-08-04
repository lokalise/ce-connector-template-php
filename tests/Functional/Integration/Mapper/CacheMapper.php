<?php

namespace App\Tests\Functional\Integration\Mapper;

use App\DTO\UniqueItemIdentifier;
use App\Interfaces\Mapper\CacheMapperInterface;
use JetBrains\PhpStorm\ArrayShape;

class CacheMapper implements CacheMapperInterface
{
    #[ArrayShape([
        'uniqueId' => 'string',
        'groupId' => 'string',
        'metadata' => 'string[]',
    ])]
    public function mapCacheToArray(UniqueItemIdentifier $uniqueItem): array
    {
        return [
            'uniqueId' => $uniqueItem->uniqueId,
            'groupId' => $uniqueItem->groupId,
            'metadata' => $uniqueItem->metadata,
        ];
    }

    public function mapArrayToCache(
        #[ArrayShape([
            'uniqueId' => 'string',
            'groupId' => 'string',
            'metadata' => 'string[]',
        ])]
        array $item,
    ): UniqueItemIdentifier {
        $uniqueItem = new UniqueItemIdentifier();
        $uniqueItem->uniqueId = $item['uniqueId'];
        $uniqueItem->groupId = $item['groupId'];
        $uniqueItem->metadata = $item['metadata'];

        return $uniqueItem;
    }
}