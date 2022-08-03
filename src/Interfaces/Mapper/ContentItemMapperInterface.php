<?php

namespace App\Interfaces\Mapper;

use App\DTO\ContentItem;

interface ContentItemMapperInterface
{
    public function mapArrayToContentItem(array $item): ContentItem;
}