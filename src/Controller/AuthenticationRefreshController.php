<?php

namespace App\Controller;

use App\Exception\AccessDeniedException;
use App\Integration\DTO\AuthCredentials;
use App\Integration\DTO\ConnectorConfig;
use App\Interfaces\Renderer\AuthRendererInterface;
use App\Interfaces\Service\AuthenticationServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Annotation\Route;

class AuthenticationRefreshController extends AbstractController implements AuthenticatedControllerInterface
{
    public function __construct(
        private readonly AuthenticationServiceInterface $authenticationService,
        private readonly AuthRendererInterface $authRenderer,
    ) {
    }

    #[Route(
        path: '/auth/refresh',
        methods: [Request::METHOD_POST],
        condition: "service('App\\\Service\\\AuthTypeService').isApiKey()"
    )]
    public function refreshByApiKey(AuthCredentials $credentials, ConnectorConfig $connectorConfig): Response
    {
        try {
            $authCredentials = $this->authenticationService->refreshApiKey($credentials, $connectorConfig);

            return $this->authRenderer->renderAuthCredentials($authCredentials);
        } catch (AccessDeniedException) {
            throw new AccessDeniedHttpException('Could not authenticate to 3rd party using the provided key.');
        }
    }

    #[Route(
        path: '/auth/refresh',
        methods: [Request::METHOD_POST],
        condition: "service('App\\\Service\\\AuthTypeService').isOAuth()"
    )]
    public function refreshByOAuth(AuthCredentials $credentials, ConnectorConfig $connectorConfig): Response
    {
        try {
            $authCredentials = $this->authenticationService->refreshAccessToken($credentials, $connectorConfig);

            return $this->authRenderer->renderAuthCredentials($authCredentials);
        } catch (AccessDeniedException) {
            throw new AccessDeniedHttpException('Could not authenticate to 3rd party using the provided key.');
        }
    }
}
