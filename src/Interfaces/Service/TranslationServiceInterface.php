<?php

namespace App\Interfaces\Service;

use App\DTO\TranslationItem;
use App\DTO\Identifier;
use App\Exception\AccessDeniedException;
use App\Integration\DTO\AuthCredential;

interface TranslationServiceInterface
{
    /**
     * @param array<int, string> $locales
     * @param array<int, Identifier> $identifiers
     *
     * @return array<int, TranslationItem>
     *
     * @throws AccessDeniedException
     */
    public function getTranslations(AuthCredential $authCredential, array $locales, array $identifiers): array;
}
