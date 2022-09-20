<?php

namespace App\Interfaces\Service;

use App\Exception\AccessDeniedException;
use App\Integration\DTO\AuthCredentials;
use App\Integration\DTO\ConnectorConfig;
use App\Integration\DTO\OAuthParams;

interface AuthenticationServiceInterface
{
    /**
     * @throws AccessDeniedException
     */
    public function authByApiKey(ConnectorConfig $connectorConfig): AuthCredentials;

    /**
     * @throws AccessDeniedException
     */
    public function refreshApiKey(AuthCredentials $credentials, ConnectorConfig $connectorConfig): AuthCredentials;

    public function generateAuthUrl(string $redirectUrl, ConnectorConfig $connectorConfig): string;

    /**
     * @throws AccessDeniedException
     */
    public function refreshAccessToken(AuthCredentials $credentials, ConnectorConfig $connectorConfig): AuthCredentials;

    /**
     * @throws AccessDeniedException
     */
    public function authByOAuth(
        ?OAuthParams $query,
        ?OAuthParams $body,
        string $redirectUrl,
        ConnectorConfig $connectorConfig,
    ): AuthCredentials;
}
