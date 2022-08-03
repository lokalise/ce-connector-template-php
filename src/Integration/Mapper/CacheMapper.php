<?php

namespace App\Integration\Mapper;

use App\DTO\UniqueItemIdentifier;
use App\Interfaces\Mapper\CacheMapperInterface;
use JetBrains\PhpStorm\ArrayShape;

class CacheMapper implements CacheMapperInterface
{
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