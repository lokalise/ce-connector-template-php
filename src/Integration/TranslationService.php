<?php

namespace App\Integration;

use App\DTO\UniqueItemIdentifier;
use App\Interfaces\TranslationInterface;
use JetBrains\PhpStorm\ArrayShape;

class TranslationService implements TranslationInterface
{
    /**
     * @param array<int, string> $locales
     * @param array<int, UniqueItemIdentifier> $items
     */
    public function getContent(string $accessToken, array $locales, array $items): ?array
    {
        return array_map(
            #[ArrayShape([
                'uniqueId' => 'string',
                'groupId' => 'string',
                'metadata' => 'array',
                'translations' => 'array',
            ])]
            fn (UniqueItemIdentifier $uniqueItemIdentifier) => [
                'uniqueId' => $uniqueItemIdentifier->uniqueId,
                'groupId' => $uniqueItemIdentifier->groupId,
                'metadata' => $uniqueItemIdentifier->metadata,
                'translations' => array_combine($locales, $locales),
            ],
            $items
        );
    }
}
