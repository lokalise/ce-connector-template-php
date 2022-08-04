<?php

namespace App\Interfaces\Mapper;

use App\DTO\TranslationItem;

interface ContentItemMapperInterface
{
    public function mapArrayToContentItem(array $item): TranslationItem;
}