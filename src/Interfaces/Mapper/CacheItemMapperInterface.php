<?php

namespace App\Interfaces\Mapper;

use App\DTO\CacheItem;

interface CacheItemMapperInterface
{
    public function mapArrayToCacheItem(array $item): CacheItem;
}