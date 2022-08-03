<?php

namespace App\Interfaces\Mapper;

use App\DTO\LocaleItem;

interface LocaleItemMapperInterface
{
    public function mapArrayToLocaleItem(array $locale): LocaleItem;
}