<?php

namespace App\Interfaces\Service;

use App\DTO\TranslationItem;
use App\DTO\Identifier;
use App\Exception\AccessDeniedException;

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
    public function getTranslations(string $accessToken, array $locales, array $identifiers): array;
}
