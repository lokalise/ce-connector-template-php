<?php

namespace App\Tests\Functional\Integration\Mapper;

use App\DTO\Identifier;
use App\Interfaces\Mapper\CacheMapperInterface;
use JetBrains\PhpStorm\ArrayShape;

class CacheMapper implements CacheMapperInterface
{
    #[ArrayShape([
        'uniqueId' => 'string',
        'groupId' => 'string',
        'metadata' => 'string[]',
    ])]
    public function mapCacheToArray(Identifier $identifier): array
    {
        return [
            'uniqueId' => $identifier->uniqueId,
            'groupId' => $identifier->groupId,
            'metadata' => $identifier->metadata,
        ];
    }

    public function mapArrayToCache(
        #[ArrayShape([
            'uniqueId' => 'string',
            'groupId' => 'string',
            'metadata' => 'string[]',
        ])]
        array $item,
    ): Identifier {
        $identifier = new Identifier();
        $identifier->uniqueId = $item['uniqueId'];
        $identifier->groupId = $item['groupId'];
        $identifier->metadata = $item['metadata'];

        return $identifier;
    }
}
