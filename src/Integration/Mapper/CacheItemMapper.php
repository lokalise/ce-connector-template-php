<?php

namespace App\Integration\Mapper;

use App\DTO\CacheItem;
use App\Interfaces\Mapper\CacheItemMapperInterface;
use JetBrains\PhpStorm\ArrayShape;

class CacheItemMapper implements CacheItemMapperInterface
{
    public function mapArrayToCacheItem(
        #[ArrayShape([
            'uniqueId' => 'string',
            'groupId' => 'string',
            'title' => 'string',
            'metadata' => 'array',
            'fields' => 'array',
        ])]
        array $item,
    ): CacheItem {
        $cacheItem = new CacheItem();
        $cacheItem->uniqueId = $item['uniqueId'];
        $cacheItem->groupId = $item['groupId'];
        $cacheItem->title = $item['title'];
        $cacheItem->metadata = $item['metadata'];
        $cacheItem->fields = $item['fields'];

        return $cacheItem;
    }
}
