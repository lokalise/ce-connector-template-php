<?php

namespace App\Interfaces\Mapper;

use App\DTO\Identifier;

interface CacheMapperInterface
{
    public function mapArrayToCache(array $item): Identifier;
}
