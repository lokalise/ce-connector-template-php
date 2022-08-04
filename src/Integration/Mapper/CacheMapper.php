<?php

namespace App\Integration\Mapper;

use App\DTO\Identifier;
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
    ): Identifier {
        $identifier = new Identifier();
        $identifier->uniqueId = $item['uniqueId'];
        $identifier->groupId = $item['groupId'];
        $identifier->metadata = $item['metadata'];

        return $identifier;
    }
}
