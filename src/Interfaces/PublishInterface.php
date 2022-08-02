<?php

namespace App\Interfaces;

use App\DTO\ContentItem;

interface PublishInterface
{
    /**
     * @param array<int, ContentItem> $items
     */
    public function publishContent(string $accessToken, array $items): bool;
}
