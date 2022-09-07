<?php

namespace App\Integration\Service;

use App\Integration\DTO\ConnectorConfig;
use App\Integration\DTO\OAuthClientToken;
use App\Integration\DTO\OAuthParams;
use App\Interfaces\Service\AuthenticationServiceInterface;

class AuthenticationService implements AuthenticationServiceInterface
{
    public function authByApiKey(string $apiKey, ConnectorConfig $connectorConfig): string
    {
        return $apiKey;
    }

    public function refreshApiKey(string $refreshKey, ConnectorConfig $connectorConfig): string
    {
        return $this->authByApiKey($refreshKey, $connectorConfig);
    }

    public function generateAuthUrl(string $redirectUrl, ConnectorConfig $connectorConfig): string
    {
        return sprintf(
            "https://authorization-server.com/auth?response_type=code&client_id=CLIENT_ID&redirect_uri=%s&scope=scope&state=",
            $redirectUrl,
        );
    }

    public function refreshAccessToken(string $refreshToken, ConnectorConfig $connectorConfig): OAuthClientToken
    {
        return new OAuthClientToken('access_token', $refreshToken, 3600);
    }

    public function authByOAuth(
        ?OAuthParams $query,
        ?OAuthParams $body,
        string $redirectUrl,
        ConnectorConfig $connectorConfig,
    ): OAuthClientToken {
        return new OAuthClientToken('access_token', 'refresh_token', 3600);
    }
}
