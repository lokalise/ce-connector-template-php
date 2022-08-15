<?php

namespace App\Integration\Mapper;

use App\DTO\LocaleItem;
use App\Interfaces\Mapper\LocaleItemMapperInterface;

class LocaleItemMapper implements LocaleItemMapperInterface
{
    /**
     * @param array{
     *     code: string,
     *     name: string,
     * } $locale
     */
    public function mapArrayToLocaleItem(array $locale): LocaleItem
    {
        $localeItem = new LocaleItem();
        $localeItem->code = $locale['code'];
        $localeItem->name = $locale['name'];

        return $localeItem;
    }
}
