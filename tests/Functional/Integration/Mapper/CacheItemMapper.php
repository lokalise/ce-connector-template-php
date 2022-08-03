<?php

namespace App\Tests\Functional\Integration\Mapper;

use App\DTO\CacheItem;
use App\Interfaces\Mapper\CacheItemMapperInterface;
use JetBrains\PhpStorm\ArrayShape;

class CacheItemMapper implements CacheItemMapperInterface
{
    public function mapArrayToCacheItem(
        #[ArrayShape([
            'uniqueId' => 'string',
            'groupId' => 'string',
            'metadata' => 'string[]',
        ])]
        array $item,
    ): CacheItem {
        $cacheItem = new CacheItem();
        $cacheItem->uniqueId = $item['uniqueId'];
        $cacheItem->groupId = $item['groupId'];
        $cacheItem->metadata = $item['metadata'];
        $cacheItem->fields = $item['metadata'];

        return $cacheItem;
    }
}