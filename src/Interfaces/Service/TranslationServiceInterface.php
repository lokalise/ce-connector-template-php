<?php

namespace App\Interfaces\Service;

use App\DTO\Request\TranslateRequest;
use App\DTO\TranslationItem;
use App\Exception\AccessDeniedException;
use App\Integration\DTO\AuthCredentials;

interface TranslationServiceInterface
{
    /**
     * @return array<int, TranslationItem>
     *
     * @throws AccessDeniedException
     */
    public function getTranslations(AuthCredentials $credentials, TranslateRequest $translateRequest): array;
}
