<?php

namespace App\Integration\Service;

use App\Interfaces\ApiClientInterface;
use App\Interfaces\Service\AuthenticationServiceInterface;

class AuthenticationService implements AuthenticationServiceInterface
{
    public function __construct(
        private readonly ApiClientInterface $apiClient,
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
