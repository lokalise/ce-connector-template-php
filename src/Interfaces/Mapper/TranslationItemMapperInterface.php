<?php

namespace App\Interfaces\Mapper;

use App\DTO\TranslationItem;

interface TranslationItemMapperInterface
{
    public function mapArrayToTranslationItem(array $item): TranslationItem;
}
