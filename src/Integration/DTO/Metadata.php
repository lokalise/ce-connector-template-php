<?php

namespace App\Integration\DTO;

/**
 * вспомогательные данные необходимые конектору для мапинга между сущностями конектора и сущностями 3-й стороны
 */
class Metadata
{
    public function __construct(
        public readonly string $contentType,
        public readonly string $field,
    ) {
    }
}
