<?php

namespace App\Interfaces;

interface ApiClientInterface
{
    public function auth(string $key): string;

    public function refresh(string $refreshKey): string;

    public function getCache(string $accessToken): array;

    public function getCacheItems(string $accessToken, array $identifiers): array;

    public function getEnvironments(string $accessToken): array;

    public function publish(string $accessToken, array $translations): void;

    public function getTranslations(string $accessToken, array $locales, array $identifiers): array;
}