<?php

namespace App\Integration\Mapper;

use App\DTO\LocaleItem;
use App\Interfaces\Mapper\LocaleItemMapperInterface;
use JetBrains\PhpStorm\ArrayShape;

class LocaleItemMapper implements LocaleItemMapperInterface
{
    public function mapArrayToLocaleItem(
        #[ArrayShape([
            'code' => 'string',
            'name' => 'string',
        ])]
        array $locale,
    ): LocaleItem {
        $localeItem = new LocaleItem();
        $localeItem->code = $locale['code'];
        $localeItem->name = $locale['name'];

        return $localeItem;
    }
}
