<?php

namespace App\DTO;

class CacheItem extends Identifier
{
    public ?string $title = null;

    /**
     * @var array<string, string>|null
     */
    public ?array $fields = null;
}
