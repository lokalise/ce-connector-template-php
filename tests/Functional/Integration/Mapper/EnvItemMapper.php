<?php

namespace App\Tests\Functional\Integration\Mapper;

use App\DTO\EnvItem;
use App\Interfaces\Mapper\EnvItemMapperInterface;
use App\Interfaces\Mapper\LocaleItemMapperInterface;
use JetBrains\PhpStorm\ArrayShape;

class EnvItemMapper implements EnvItemMapperInterface
{
    public function __construct(
        private readonly LocaleItemMapperInterface $localeItemMapper,
    ) {
    }

    public function mapArrayToEnvItem(
        #[ArrayShape([
            'defaultLocale' => 'string',
            'locales' => 'string[]',
            'cacheItemStructure' => 'string[]',
        ])]
        array $environment
    ): EnvItem {
        $item = new EnvItem();
        $item->defaultLocale = $environment['defaultLocale'];
        $item->locales = array_map(
            fn (array $locale) => $this->localeItemMapper->mapArrayToLocaleItem($locale),
            $environment['locales'],
        );
        $item->cacheItemStructure = $environment['cacheItemStructure'];

        return $item;
    }
}
