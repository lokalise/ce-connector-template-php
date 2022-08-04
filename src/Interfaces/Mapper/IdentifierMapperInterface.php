<?php

namespace App\Interfaces\Mapper;

use App\DTO\Identifier;

interface IdentifierMapperInterface
{
    public function mapIdentifierToArray(Identifier $identifier): array;
}