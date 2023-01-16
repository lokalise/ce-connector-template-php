<?php

namespace App\Controller;

use App\DTO\Request\AuthenticationRequest;
use App\DTO\Request\OAuthRequest;
use App\Integration\DTO\ConnectorConfig;
use App\Interfaces\Service\AuthenticationServiceInterface;
use App\Renderer\AuthMethodRenderer;
use App\Renderer\AuthRenderer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/v2')]
class AuthenticationController extends AbstractController
{
    public function __construct(
        private readonly AuthenticationServiceInterface $authenticationService,
        private readonly AuthMethodRenderer $authMethodRenderer,
        private readonly AuthRenderer $authRenderer,
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
        condition: "service('App\\\Service\\\AuthTypeService').isApiKey()",
    )]
    public function authByApiKey(ConnectorConfig $connectorConfig): Response
    {
        $credentials = $this->authenticationService->authByApiKey($connectorConfig);

        return $this->authRenderer->renderAuthCredentials($credentials);
    }

    #[Route(
        path: '/auth',
        methods: [Request::METHOD_POST],
        condition: "service('App\\\Service\\\AuthTypeService').isOAuth()",
    )]
    public function generateAuthUrl(
        AuthenticationRequest $authenticationRequest,
        ConnectorConfig $connectorConfig,
    ): Response {
        $url = $this->authenticationService->generateAuthUrl(
            $authenticationRequest->redirectUrl,
            $authenticationRequest->state,
            $connectorConfig,
        );

        return $this->authRenderer->renderUrl($url);
    }

    #[Route(
        path: '/auth/response',
        methods: [Request::METHOD_POST],
        condition: "service('App\\\Service\\\AuthTypeService').isOAuth()",
    )]
    public function authByOAuth(OAuthRequest $oAuthRequest, ConnectorConfig $connectorConfig): Response
    {
        $credentials = $this->authenticationService->authByOAuth(
            $oAuthRequest->query,
            $oAuthRequest->body,
            $oAuthRequest->redirectUrl,
            $connectorConfig,
        );

        return $this->authRenderer->renderAuthCredentials($credentials);
    }
}
