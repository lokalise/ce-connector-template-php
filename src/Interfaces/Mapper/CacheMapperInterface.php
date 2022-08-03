<?php

namespace App\Interfaces\Mapper;

use App\DTO\UniqueItemIdentifier;

interface CacheMapperInterface
{
    public function mapArrayToCache(array $item): UniqueItemIdentifier;
}