<?php

namespace App\DTO;

use App\Integration\DTO\CacheItemFields;

class CacheItem extends Identifier
{
    public ?string $title = null;

    public ?CacheItemFields $fields = null;
}
