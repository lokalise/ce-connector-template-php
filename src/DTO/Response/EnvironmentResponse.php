<?php

namespace App\DTO\Response;

use App\DTO\LocaleItem;
use App\Integration\DTO\CacheItemStructure;

class EnvironmentResponse
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
