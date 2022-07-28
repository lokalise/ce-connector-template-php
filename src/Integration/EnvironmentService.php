<?php

namespace App\Integration;

use App\DTO\EnvItem;
use App\DTO\LocaleItem;
use App\Interfaces\EnvironmentInterface;

class EnvironmentService implements EnvironmentInterface
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
