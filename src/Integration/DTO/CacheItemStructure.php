<?php

namespace App\Integration\DTO;

/**
 * Additional column headings that will be displayed in the Lokalise UI application for your connector.
 */
class CacheItemStructure
{
    public function __construct(
        public readonly string $id = 'ID',
        public readonly string $createdAt = 'Created at',
    ) {
    }
}
