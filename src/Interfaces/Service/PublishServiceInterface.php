<?php

namespace App\Interfaces\Service;

use App\DTO\ContentItem;
use App\Exception\AccessDeniedException;

interface PublishServiceInterface
{
    /**
     * @param array<int, ContentItem> $translations
     *
     * @throws AccessDeniedException
     */
    public function publishContent(string $accessToken, array $translations): void;
}
