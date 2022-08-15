<?php

namespace App\Integration\Mapper;

use App\DTO\EnvItem;
use App\Interfaces\Mapper\EnvItemMapperInterface;
use App\Interfaces\Mapper\LocaleItemMapperInterface;

class EnvItemMapper implements EnvItemMapperInterface
{
    public function __construct(
        private readonly LocaleItemMapperInterface $localeItemMapper,
    ) {
    }

    /**
     * @param array{
     *     defaultLocale: string,
     *     languages: array,
     *     cacheItemStructure: array,
     * } $environment
     */
    public function mapArrayToEnvItem(array $environment): EnvItem
    {
        $item = new EnvItem();
        $item->defaultLocale = $environment['defaultLocale'];
        $item->locales = array_map(
            fn (array $language) => $this->localeItemMapper->mapArrayToLocaleItem($language),
            $environment['languages'],
        );
        $item->cacheItemStructure = $environment['cacheItemStructure'];

        return $item;
    }
}
