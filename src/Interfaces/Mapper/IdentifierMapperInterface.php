<?php

namespace App\Interfaces\Mapper;

use App\DTO\UniqueItemIdentifier;

interface IdentifierMapperInterface
{
    public function mapIdentifierToArray(UniqueItemIdentifier $identifier): array;
}