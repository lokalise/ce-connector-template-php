<?php

namespace App\Tests\Integration\Service;

use App\DTO\CacheItem;
use App\DTO\UniqueItemIdentifier;
use App\Interfaces\CacheInterface;
use App\Tests\Integration\AbstractApiTestCase;

class CacheTestService implements CacheInterface
{
    /**
     * @return array<int, UniqueItemIdentifier>|null
     */
    public function listItems(string $accessToken): ?array
    {
        $item = new UniqueItemIdentifier();
        $item->uniqueId = AbstractApiTestCase::UNIQUE_ID;
        $item->groupId = AbstractApiTestCase::GROUP_ID;
        $item->metadata = AbstractApiTestCase::METADATA;

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
