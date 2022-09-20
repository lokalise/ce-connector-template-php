<?php

namespace App\Controller;

use App\DTO\Request\AuthenticationRequest;
use App\DTO\Request\OAuthRequest;
use App\Enum\AuthTypeEnum;
use App\Exception\AccessDeniedException;
use App\Integration\DTO\ConnectorConfig;
use App\Interfaces\Renderer\AuthMethodRendererInterface;
use App\Interfaces\Renderer\AuthRendererInterface;
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
        condition: "service('App\\\Service\\\AuthTypeService').isApiKey()"
    )]
    public function authByApiKey(ConnectorConfig $connectorConfig): Response
    {
        try {
            $credentials = $this->authenticationService->authByApiKey($connectorConfig);

            return $this->authRenderer->renderAuthCredentials($credentials);
        } catch (AccessDeniedException) {
            throw new AccessDeniedHttpException('Could not authenticate to 3rd party using the provided key.');
        }
    }

    #[Route(
        path: '/auth',
        methods: [Request::METHOD_POST],
        condition: "service('App\\\Service\\\AuthTypeService').isOAuth()"
    )]
    public function generateAuthUrl(
        AuthenticationRequest $authenticationRequest,
        ConnectorConfig $connectorConfig
    ): Response {
        try {
            $url = $this->authenticationService->generateAuthUrl($authenticationRequest->redirectUrl, $connectorConfig);

            return $this->authRenderer->renderUrl($url);
        } catch (AccessDeniedException) {
            throw new AccessDeniedHttpException('Could not authenticate to 3rd party using the provided key.');
        }
    }

    #[Route(
        path: '/auth/response',
        methods: [Request::METHOD_POST],
        condition: "service('App\\\Service\\\AuthTypeService').isOAuth()"
    )]
    public function authByOAuth(OAuthRequest $oAuthRequest, ConnectorConfig $connectorConfig): Response
    {
        try {
            $credentials = $this->authenticationService->authByOAuth(
                $oAuthRequest->query,
                $oAuthRequest->body,
                $oAuthRequest->redirectUrl,
                $connectorConfig,
            );

            return $this->authRenderer->renderAuthCredentials($credentials);
        } catch (AccessDeniedException) {
            throw new AccessDeniedHttpException('Could not authenticate to 3rd party using the provided key.');
        }
    }
}
