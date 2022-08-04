<?php

namespace App\Tests\Functional\Integration;

use App\Interfaces\ApiClientInterface;
use App\Tests\Functional\DataProvider\EnvironmentDataProvider;
use App\Tests\Functional\DataProvider\IdentifierDataProvider;

class ApiClient implements ApiClientInterface
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
        return [IdentifierDataProvider::UNIQUE_ITEM_IDENTIFIER];
    }

    public function getCacheItems(string $accessToken, array $identifiers): array
    {
        return array_map(
            static fn (array $identifier) => array_merge($identifier, [
                'fields' => $identifier['metadata'],
            ]),
            $identifiers,
        );
    }

    public function getEnvironments(string $accessToken): array
    {
        return EnvironmentDataProvider::ENVIRONMENTS;
    }

    public function publish(string $accessToken, array $translations): void
    {

    }

    public function getTranslations(string $accessToken, array $locales, array $identifiers): array
    {
        return array_map(
            static fn (array $identifier) => array_merge($identifier, [
                'translations' => array_combine($locales, $locales),
            ]),
            $identifiers,
        );
    }
}
