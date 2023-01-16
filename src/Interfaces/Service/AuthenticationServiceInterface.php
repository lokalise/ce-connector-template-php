<?php

namespace App\Interfaces\Service;

use App\Integration\DTO\AuthCredentials;
use App\Integration\DTO\ConnectorConfig;
use App\Integration\DTO\OAuthParams;

interface AuthenticationServiceInterface
{
    public function authByApiKey(ConnectorConfig $connectorConfig): AuthCredentials;

    public function refreshApiKey(AuthCredentials $credentials, ConnectorConfig $connectorConfig): AuthCredentials;

    public function generateAuthUrl(string $redirectUrl, string $state, ConnectorConfig $connectorConfig): string;

    public function refreshAccessToken(AuthCredentials $credentials, ConnectorConfig $connectorConfig): AuthCredentials;

    public function authByOAuth(
        ?OAuthParams $query,
        ?OAuthParams $body,
        string $redirectUrl,
        ConnectorConfig $connectorConfig,
    ): AuthCredentials;
}
