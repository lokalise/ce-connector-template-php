<?php

namespace App\Tests\Integration\Service;

use App\DTO\EnvItem;
use App\DTO\LocaleItem;
use App\Interfaces\EnvironmentInterface;
use App\Tests\Integration\DataProvider\EnvironmentDataProvider;

class EnvironmentTestService implements EnvironmentInterface
{
    /**
     * @return array<int, EnvItem>|null
     */
    public function getEnv(string $accessToken): ?array
    {
        $locale = new LocaleItem();
        $locale->code = EnvironmentDataProvider::LOCALE_CODE;
        $locale->name = EnvironmentDataProvider::LOCALE_NAME;

        $item = new EnvItem();
        $item->defaultLocale = EnvironmentDataProvider::LOCALE_CODE;
        $item->locales = [$locale];
        $item->cacheItemStructure = EnvironmentDataProvider::CACHE_ITEM_STRUCTURE;

        return [$item];
    }
}
