<?php

namespace App\Interfaces\Service;

use App\DTO\TranslationItem;
use App\Exception\AccessDeniedException;

interface PublishServiceInterface
{
    /**
     * @param array<int, TranslationItem> $translations
     *
     * @throws AccessDeniedException
     */
    public function publishContent(string $accessToken, array $translations): void;
}
