<?php

namespace App\DTO;

class CacheItem extends Identifier
{
    /**
     * @var array<string, string>|null
     */
    public ?array $fields = null;
}
