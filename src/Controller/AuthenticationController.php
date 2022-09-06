<?php

namespace App\Controller;

use App\DTO\Request\AuthenticationRequest;
use App\DTO\Request\OAuthRequest;
use App\DTO\Request\RefreshRequest;
use App\Enum\AuthTypeEnum;
use App\Exception\AccessDeniedException;
use App\Integration\DTO\ConnectorConfig;
use App\Interfaces\Renderer\AuthMethodRendererInterface;
use App\Interfaces\Renderer\AuthRendererInterface;
use App\Interfaces\Renderer\RefreshRendererInterface;
use App\Interfaces\Service\AuthenticationServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Annotation\Route;

class AuthenticationController extends AbstractController
{
    public function __construct(
        private readonly AuthenticationServiceInterface $authenticationService,
        private readonly AuthMethodRendererInterface $authMethodRenderer,
        private readonly AuthRendererInterface $authRenderer,
        private readonly RefreshRendererInterface $refreshRenderer,
        private readonly AuthTypeEnum $defaultAuthType,
    ) {
    }

    #[Route(
        path: '/auth',
        methods: [Request::METHOD_GET],
    )]
    public function getMethod(): Response
    {
        return $this->authMethodRenderer->render();
    }

    #[Route(
        path: '/auth',
        methods: [Request::METHOD_POST],
    )]
    public function auth(AuthenticationRequest $authenticationRequest, ConnectorConfig $connectorConfig): Response
    {
        try {
            return match ($this->defaultAuthType) {
                AuthTypeEnum::apiKey => $this->authByApiKey($authenticationRequest, $connectorConfig),
                AuthTypeEnum::OAuth => $this->generateAuthUrl($authenticationRequest, $connectorConfig),
            };
        } catch (AccessDeniedException) {
            throw new AccessDeniedHttpException('Could not authenticate to 3rd party using the provided key.');
        }
    }

    /**
     * @throws AccessDeniedException
     */
    private function authByApiKey(
        AuthenticationRequest $authenticationRequest,
        ConnectorConfig $connectorConfig,
    ): Response {
        $key = $this->authenticationService->authByApiKey($authenticationRequest->key, $connectorConfig);

        return $this->authRenderer->renderKey($key);
    }

    private function generateAuthUrl(
        AuthenticationRequest $authenticationRequest,
        ConnectorConfig $connectorConfig,
    ): Response {
        $url = $this->authenticationService->generateAuthUrl($authenticationRequest->redirectUrl, $connectorConfig);

        return $this->authRenderer->renderUrl($url);
    }

    #[Route(
        path: '/auth/response',
        methods: [Request::METHOD_POST],
    )]
    public function authByOAuth(OAuthRequest $oAuthRequest, ConnectorConfig $connectorConfig): Response
    {
        try {
            if ($this->defaultAuthType === AuthTypeEnum::apiKey) {
                throw new AccessDeniedException();
            }

            $token = $this->authenticationService->authByOAuth(
                $oAuthRequest->query,
                $oAuthRequest->body,
                $oAuthRequest->redirectUrl,
                $connectorConfig,
            );

            return $this->authRenderer->renderAccessCredentials($token);
        } catch (AccessDeniedException) {
            throw new AccessDeniedHttpException('Could not authenticate to 3rd party using the provided key.');
        }
    }

    #[Route(
        path: '/auth/refresh',
        methods: [Request::METHOD_POST],
    )]
    public function refresh(RefreshRequest $refreshRequest, ConnectorConfig $connectorConfig): Response
    {
        try {
            return match ($this->defaultAuthType) {
                AuthTypeEnum::apiKey => $this->refreshByApiKey($refreshRequest, $connectorConfig),
                AuthTypeEnum::OAuth => $this->refreshByOAuth($refreshRequest, $connectorConfig),
            };
        } catch (AccessDeniedException) {
            throw new AccessDeniedHttpException('Could not authenticate to 3rd party using the provided key.');
        }
    }

    /**
     * @throws AccessDeniedException
     */
    private function refreshByApiKey(RefreshRequest $refreshRequest, ConnectorConfig $connectorConfig): Response
    {
        $refreshKey = $this->authenticationService->refreshApiKey($refreshRequest->refreshToken, $connectorConfig);

        return $this->refreshRenderer->render($refreshKey);
    }

    /**
     * @throws AccessDeniedException
     */
    private function refreshByOAuth(RefreshRequest $refreshRequest, ConnectorConfig $connectorConfig): Response
    {
        $token = $this->authenticationService->refreshAccessToken($refreshRequest->refreshToken, $connectorConfig);

        return $this->authRenderer->renderAccessCredentials($token);
    }
}
