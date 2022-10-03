<?php

namespace App\Integration\DTO;

/**
 * Fields that will contain values for columns that have been defined using the {@link CacheItemStructure}.
 */
class CacheItemFields
{
    public function __construct(
        public readonly string $id,
    ) {
    }
}
