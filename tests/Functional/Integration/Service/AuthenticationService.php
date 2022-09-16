<?php

namespace App\Tests\Functional\Integration\Service;

use App\Exception\AccessDeniedException;
use App\Integration\DTO\AuthCredentials;
use App\Integration\DTO\ConnectorConfig;
use App\Integration\DTO\OAuthParams;
use App\Interfaces\Service\AuthenticationServiceInterface;
use App\Tests\Functional\DataProvider\AuthenticationDataProvider;

class AuthenticationService implements AuthenticationServiceInterface
{
    public function authByApiKey(ConnectorConfig $connectorConfig): AuthCredentials
    {
        $apiKey = $connectorConfig->apiKey;

        if ($apiKey === AuthenticationDataProvider::FAILED_API_KEY) {
            throw new AccessDeniedException();
        }

        return new AuthCredentials($apiKey);
    }

    public function refreshApiKey(AuthCredentials $credentials, ConnectorConfig $connectorConfig): AuthCredentials
    {
        return $this->authByApiKey($connectorConfig);
    }

    public function generateAuthUrl(string $redirectUrl, ConnectorConfig $connectorConfig): string
    {
        return AuthenticationDataProvider::AUTH_URL;
    }

    public function refreshAccessToken(AuthCredentials $credentials, ConnectorConfig $connectorConfig): AuthCredentials
    {
        return $this->authByApiKey($connectorConfig);
    }

    public function authByOAuth(
        ?OAuthParams $query,
        ?OAuthParams $body,
        string $redirectUrl,
        ConnectorConfig $connectorConfig,
    ): AuthCredentials {
        return $this->authByApiKey($connectorConfig);
    }
}
