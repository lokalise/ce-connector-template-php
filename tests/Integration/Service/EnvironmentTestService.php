<?php

namespace App\Tests\Integration\Service;

use App\DTO\EnvItem;
use App\DTO\LocaleItem;
use App\Interfaces\EnvironmentInterface;

class EnvironmentTestService implements EnvironmentInterface
{
    const LOCALE_CODE = 'de';
    const LOCALE_NAME = 'German';
    const CACHE_ITEM_STRUCTURE = [
        "title" => "Title",
    ];

    /**
     * @return array<int, EnvItem>|null
     */
    public function getEnv(string $accessToken): ?array
    {
        $locale = new LocaleItem();
        $locale->code = self::LOCALE_CODE;
        $locale->name = self::LOCALE_NAME;

        $item = new EnvItem();
        $item->defaultLocale = self::LOCALE_CODE;
        $item->locales = [$locale];
        $item->cacheItemStructure = self::CACHE_ITEM_STRUCTURE;

        return [$item];
    }
}
