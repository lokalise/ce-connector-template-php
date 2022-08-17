<?php

namespace App\DTO;

use App\Integration\DTO\CacheItemStructure;

class EnvItem
{
    /**
     * @param array<int, LocaleItem> $locales
     */
    public function __construct(
        public readonly string $defaultLocale,
        public readonly array $locales,
        public readonly CacheItemStructure $cacheItemStructure,
    ) {
    }
}
