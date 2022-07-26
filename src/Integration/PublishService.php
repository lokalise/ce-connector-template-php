<?php

namespace App\Integration;

use App\DTO\ContentItem;
use App\Interfaces\PublishInterface;

class PublishService implements PublishInterface
{
    /**
     * @param array<int, ContentItem> $items
     */
    public function publishContent(string $accessToken, array $items): bool
    {
        return true;
    }
}