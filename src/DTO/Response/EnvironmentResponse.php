<?php

namespace App\DTO\Response;

use App\DTO\LocaleItem;

class EnvironmentResponse
{
    /**
     * @param array<int, LocaleItem>|null $locales
     * @param array<string, string>|null $cacheItemStructure
     */
    public function __construct(
        public readonly string $defaultLocale,
        public readonly array $locales,
        public readonly array $cacheItemStructure,
    ) {
    }
}
