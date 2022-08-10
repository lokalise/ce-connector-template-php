<?php

namespace App\Integration;

use JetBrains\PhpStorm\ArrayShape;

class ApiClient
{
    public function auth(string $key): string
    {
        return $key;
    }

    public function refresh(string $refreshKey): string
    {
        return $refreshKey;
    }

    public function getCache(string $accessToken): array
    {
        return [
            [
                'uniqueId' => 'post:1:title',
                'groupId' => 'post:1',
                'metadata' => [
                    'contentType' => 'post',
                    'field' => 'title',
                ],
            ],
        ];
    }

    public function getCacheItems(string $accessToken, array $identifiers): array
    {
        $cacheItems = [];

        foreach ($identifiers as $identifier) {
            $cacheItems[] = [
                'uniqueId' => $identifier['uniqueId'],
                'groupId' => $identifier['groupId'],
                'title' => $identifier['uniqueId'] . $identifier['groupId'],
                'metadata' => $identifier['metadata'],
                'fields' => $identifier['metadata']
            ];
        }

        return $cacheItems;
    }

    #[ArrayShape([
        'defaultLocale' => 'string',
        'locales' => 'array',
        'cacheItemStructure' => 'array',
    ])]
    public function getEnvironments(string $accessToken): array
    {
        return [
            'defaultLocale' => 'de',
            'locales' => [
                [
                    'code' => 'de',
                    'name' => 'German',
                ],
            ],
            'cacheItemStructure' => [
                'title' => 'Title',
            ],
        ];
    }

    public function publish(string $accessToken, array $translations): void
    {
    }

    public function getTranslations(string $accessToken, array $locales, array $identifiers): array
    {
        return array_map(
            static fn(array $item) => array_merge($item, [
                'translations' => array_combine($locales, $locales),
            ]),
            $identifiers,
        );
    }
}
