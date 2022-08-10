<?php

namespace App\Integration\Service;

use App\Integration\ApiClient;
use App\Interfaces\Service\AuthenticationServiceInterface;

class AuthenticationService implements AuthenticationServiceInterface
{
    public function __construct(
        private readonly ApiClient $apiClient,
    ) {
    }

    public function auth(string $key): string
    {
        return $this->apiClient->auth($key);
    }

    public function refresh(string $refreshKey): string
    {
        return $this->apiClient->refresh($refreshKey);
    }
}
