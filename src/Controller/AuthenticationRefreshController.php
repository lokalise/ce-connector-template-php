<?php

namespace App\Controller;

use App\Integration\DTO\AuthCredentials;
use App\Integration\DTO\ConnectorConfig;
use App\Interfaces\Service\AuthenticationServiceInterface;
use App\Renderer\AuthRenderer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/v2')]
class AuthenticationRefreshController extends AbstractController implements AuthenticatedControllerInterface
{
    public function __construct(
        private readonly AuthenticationServiceInterface $authenticationService,
        private readonly AuthRenderer $authRenderer,
    ) {
    }

    #[Route(
        path: '/auth/refresh',
        methods: [Request::METHOD_POST],
        condition: "service('App\\\Service\\\AuthTypeService').isApiKey()",
    )]
    public function refreshByApiKey(AuthCredentials $credentials, ConnectorConfig $connectorConfig): Response
    {
        $authCredentials = $this->authenticationService->refreshApiKey($credentials, $connectorConfig);

        return $this->authRenderer->renderAuthCredentials($authCredentials);
    }

    #[Route(
        path: '/auth/refresh',
        methods: [Request::METHOD_POST],
        condition: "service('App\\\Service\\\AuthTypeService').isOAuth()",
    )]
    public function refreshByOAuth(AuthCredentials $credentials, ConnectorConfig $connectorConfig): Response
    {
        $authCredentials = $this->authenticationService->refreshAccessToken($credentials, $connectorConfig);

        return $this->authRenderer->renderAuthCredentials($authCredentials);
    }
}
