<?php

namespace App\Tests\Integration\Service;

use App\DTO\CacheItem;
use App\DTO\UniqueItemIdentifier;
use App\Interfaces\CacheInterface;

class CacheTestService implements CacheInterface
{
    /**
     * @return array<int, UniqueItemIdentifier>|null
     */
    public function listItems(string $accessToken): ?array
    {
        $item = new UniqueItemIdentifier();
        $item->uniqueId = "post:1:title";
        $item->groupId = "post:1";
        $item->metadata = [
            "contentType" => "post",
            "field" => "title"
        ];

        return [$item];
    }

    /**
     * @param array<int, UniqueItemIdentifier> $items
     *
     * @return array<int, CacheItem>|null
     */
    public function getItems(string $accessToken, array $items): ?array
    {
        return array_map(
            function (UniqueItemIdentifier $uniqueItemIdentifier): CacheItem {
                $cacheItem = new CacheItem();
                $cacheItem->uniqueId = $uniqueItemIdentifier->uniqueId;
                $cacheItem->groupId = $uniqueItemIdentifier->groupId;
                $cacheItem->metadata = $uniqueItemIdentifier->metadata;
                $cacheItem->fields = $uniqueItemIdentifier->metadata;

                return $cacheItem;
            },
            $items
        );
    }
}
