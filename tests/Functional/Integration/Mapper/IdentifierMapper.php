<?php

namespace App\Tests\Functional\Integration\Mapper;

use App\DTO\UniqueItemIdentifier;
use App\Interfaces\Mapper\IdentifierMapperInterface;
use JetBrains\PhpStorm\ArrayShape;

class IdentifierMapper implements IdentifierMapperInterface
{
    #[ArrayShape([
        'uniqueId' => 'string',
        'groupId' => 'string',
        'metadata' => 'string[]',
    ])]
    public function mapIdentifierToArray(UniqueItemIdentifier $identifier): array
    {
        return [
            'uniqueId' => $identifier->uniqueId,
            'groupId' => $identifier->groupId,
            'metadata' => $identifier->metadata,
        ];
    }
}