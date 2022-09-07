<?php

namespace App\Tests\Functional\Integration\Service;

use App\Exception\AccessDeniedException;
use App\Integration\DTO\ConnectorConfig;
use App\Integration\DTO\OAuthClientToken;
use App\Integration\DTO\OAuthParams;
use App\Interfaces\Service\AuthenticationServiceInterface;
use App\Tests\Functional\DataProvider\AuthenticationDataProvider;

class AuthenticationService implements AuthenticationServiceInterface
{
    public function authByApiKey(string $apiKey, ConnectorConfig $connectorConfig): string
    {
        if ($apiKey === AuthenticationDataProvider::FAILED_API_KEY) {
            throw new AccessDeniedException();
        }

        return $apiKey;
    }

    public function refreshApiKey(string $refreshKey, ConnectorConfig $connectorConfig): string
    {
        return $this->authByApiKey($refreshKey, $connectorConfig);
    }

    public function generateAuthUrl(string $redirectUrl, ConnectorConfig $connectorConfig): string
    {
        return AuthenticationDataProvider::AUTH_URL;
    }

    public function refreshAccessToken(string $refreshToken, ConnectorConfig $connectorConfig): OAuthClientToken
    {
        return new OAuthClientToken(
            AuthenticationDataProvider::ACCESS_TOKEN,
            AuthenticationDataProvider::REFRESH_TOKEN,
            AuthenticationDataProvider::EXPIRES_IN,
        );
    }

    public function authByOAuth(
        ?OAuthParams $query,
        ?OAuthParams $body,
        string $redirectUrl,
        ConnectorConfig $connectorConfig,
    ): OAuthClientToken {
        return new OAuthClientToken(
            AuthenticationDataProvider::ACCESS_TOKEN,
            AuthenticationDataProvider::REFRESH_TOKEN,
            AuthenticationDataProvider::EXPIRES_IN,
        );
    }
}
