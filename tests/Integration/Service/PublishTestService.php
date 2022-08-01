<?php

namespace App\Tests\Integration\Service;

use App\DTO\ContentItem;
use App\Interfaces\PublishInterface;

class PublishTestService implements PublishInterface
{
    /**
     * @param array<int, ContentItem> $items
     */
    public function publishContent(string $accessToken, array $items): bool
    {
        return true;
    }
}
