<?php

namespace App\Controller;

use App\Exception\AccessDeniedException;
use App\Integration\DTO\AuthCredentials;
use App\Integration\DTO\ConnectorConfig;
use App\Interfaces\Renderer\EnvironmentRendererInterface;
use App\Interfaces\Service\EnvironmentServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/v2')]
class EnvironmentController extends AbstractController implements AuthenticatedControllerInterface
{
    public function __construct(
        private readonly EnvironmentServiceInterface $envService,
        private readonly EnvironmentRendererInterface $environmentRenderer,
    ) {
    }

    #[Route(
        path: '/env',
        methods: [Request::METHOD_GET],
    )]
    public function env(AuthCredentials $credentials, ConnectorConfig $connectorConfig): Response
    {
        try {
            $envResult = $this->envService->getEnvironments($credentials, $connectorConfig);

            return $this->environmentRenderer->render($envResult);
        } catch (AccessDeniedException) {
            throw new AccessDeniedHttpException('Could not retrieve content items');
        }
    }
}
