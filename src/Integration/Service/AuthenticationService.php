<?php

namespace App\Integration\Service;

use App\Integration\DTO\AuthCredentials;
use App\Integration\DTO\ConnectorConfig;
use App\Integration\DTO\OAuthParams;
use App\Interfaces\Service\AuthenticationServiceInterface;

class AuthenticationService implements AuthenticationServiceInterface
{
    public function __construct(
        private readonly string $platformClientId = '',
    ) {
    }

    public function authByApiKey(ConnectorConfig $connectorConfig): AuthCredentials
    {
        return new AuthCredentials($connectorConfig->apiKey);
    }

    public function refreshApiKey(AuthCredentials $credentials, ConnectorConfig $connectorConfig): AuthCredentials
    {
        return $this->authByApiKey($connectorConfig);
    }

    public function generateAuthUrl(string $redirectUrl, string $state, ConnectorConfig $connectorConfig): string
    {
        return sprintf(
            'https://authorization-server.com/auth?response_type=code&client_id=%s&redirect_uri=%s&scope=scope&state=%s',
            $this->platformClientId,
            $redirectUrl,
            $state,
        );
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
