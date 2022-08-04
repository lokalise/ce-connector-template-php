<?php

namespace App\Integration\Mapper;

use App\DTO\Identifier;
use App\Interfaces\Mapper\IdentifierMapperInterface;
use JetBrains\PhpStorm\ArrayShape;

class IdentifierMapper implements IdentifierMapperInterface
{
    #[ArrayShape([
        'uniqueId' => 'string',
        'groupId' => 'string',
        'metadata' => 'string[]',
    ])]
    public function mapIdentifierToArray(Identifier $identifier): array
    {
        return [
            'uniqueId' => $identifier->uniqueId,
            'groupId' => $identifier->groupId,
            'metadata' => $identifier->metadata,
        ];
    }
}
