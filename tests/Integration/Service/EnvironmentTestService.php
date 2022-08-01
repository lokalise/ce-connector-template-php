<?php

namespace App\Tests\Integration\Service;

use App\DTO\EnvItem;
use App\DTO\LocaleItem;
use App\Interfaces\EnvironmentInterface;

class EnvironmentTestService implements EnvironmentInterface
{
    /**
     * @return array<int, EnvItem>|null
     */
    public function getEnv(string $accessToken): ?array
    {
        $locale = new LocaleItem();
        $locale->code = 'de';
        $locale->name = 'German';

        $item = new EnvItem();
        $item->defaultLocale = 'de';
        $item->locales = [$locale];
        $item->cacheItemStructure = ["title" => "Title"];

        return [$item];
    }
}
