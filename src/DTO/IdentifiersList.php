<?php

namespace App\DTO;

class IdentifiersList
{
    /**
     * @param array<int, CacheItem|TranslationItem|Identifier> $items
     * @param array<int, array<string, ErrorItem>> $errors
     */
    public function __construct(
        public readonly array $items = [],
        public readonly ?string $errorMessage = null,
        public readonly array $errors = [],
    ) {
    }
}
