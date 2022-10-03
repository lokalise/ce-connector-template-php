<?php

namespace App\Integration\DTO;

/**
 * Ancillary data needed by the connector to map between connector entities and 3rd party service entities.
 */
class Metadata
{
    public function __construct(
        public readonly string $contentType,
        public readonly string $field,
    ) {
    }
}
