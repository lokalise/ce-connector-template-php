<?php

namespace App\Integration\Service;

use App\DTO\TranslationItem;
use App\Interfaces\Service\PublishServiceInterface;

class PublishService implements PublishServiceInterface
{
    /**
     * @param array<int, TranslationItem> $translations
     */
    public function publishContent(string $accessToken, array $translations): void
    {
    }
}
