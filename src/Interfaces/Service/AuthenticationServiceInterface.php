<?php

namespace App\Interfaces\Service;

use App\Exception\AccessDeniedException;
use App\Integration\DTO\ConnectorConfig;
use App\Integration\DTO\OAuthClientToken;
use App\Integration\DTO\OAuthParams;

interface AuthenticationServiceInterface
{
    /**
     * @throws AccessDeniedException
     */
    public function authByApiKey(ConnectorConfig $connectorConfig): string;

    /**
     * @throws AccessDeniedException
     */
    public function refreshApiKey(ConnectorConfig $connectorConfig): string;

    public function generateAuthUrl(string $redirectUrl, ConnectorConfig $connectorConfig): string;

    /**
     * @throws AccessDeniedException
     */
    public function refreshAccessToken(string $refreshToken, ConnectorConfig $connectorConfig): OAuthClientToken;

    /**
     * @throws AccessDeniedException
     */
    public function authByOAuth(
        ?OAuthParams $query,
        ?OAuthParams $body,
        string $redirectUrl,
        ConnectorConfig $connectorConfig,
    ): OAuthClientToken;
}
