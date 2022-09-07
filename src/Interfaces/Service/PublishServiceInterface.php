<?php

namespace App\Interfaces\Service;

use App\DTO\TranslationItem;
use App\Exception\AccessDeniedException;
use App\Integration\DTO\AccessCredentials;

interface PublishServiceInterface
{
    /**
     * @param array<int, TranslationItem> $translations
     *
     * @throws AccessDeniedException
     */
    public function publishContent(AccessCredentials $credentials, array $translations): void;
}
