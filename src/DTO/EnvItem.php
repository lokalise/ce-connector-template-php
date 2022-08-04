<?php

namespace App\DTO;

class EnvItem
{
    public ?string $defaultLocale = null;

    /**
     * @var array<int, LocaleItem>|null
     */
    public ?array $locales = null;

    /**
     * @var array<string, string>|null
     */
    public ?array $cacheItemStructure = null;
}
