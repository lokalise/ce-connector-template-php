<?php

namespace App\Integration\DTO;

/**
 *  поля которые будут содержать значения для столбцов которые были определены с помощью CacheItemStructure
 */
class CacheItemFields
{
    public function __construct(
        public readonly string $id,
    ) {
    }
}
