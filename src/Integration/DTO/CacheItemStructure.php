<?php

namespace App\Integration\DTO;

class CacheItemStructure
{
    public function __construct(
        public readonly string $id = 'ID',
    ) {
    }
}
