<?php

namespace App\Tests\Functional\Integration;

use App\Interfaces\ApiClientInterface;
use App\Tests\Functional\DataProvider\AuthenticationDataProvider;
use App\Tests\Functional\DataProvider\CacheDataProvider;
use App\Tests\Functional\DataProvider\EnvironmentDataProvider;
use App\Tests\Functional\DataProvider\TranslationDataProvider;
use App\Tests\Functional\DataProvider\UniqueItemIdentifierDataProvider;

class ApiClient implements ApiClientInterface
{
    public function auth(string $key): string
    {
        return AuthenticationDataProvider::KEY;
    }

    public function refresh(string $refreshKey): string
    {
        return AuthenticationDataProvider::REFRESH_KEY;
    }

    public function getCache(string $accessToken): array
    {
        return [UniqueItemIdentifierDataProvider::UNIQUE_ITEM_IDENTIFIER];
    }

    public function getCacheItems(string $accessToken, array $identifiers): array
    {
        return CacheDataProvider::CACHE_ITEMS;
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
        return TranslationDataProvider::TRANSLATIONS;
    }
}