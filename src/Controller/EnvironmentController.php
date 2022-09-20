<?php

namespace App\Controller;

use App\Integration\DTO\AuthCredentials;
use App\Integration\DTO\ConnectorConfig;
use App\Interfaces\Service\EnvironmentServiceInterface;
use App\Renderer\EnvironmentRenderer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/v2')]
class EnvironmentController extends AbstractController implements AuthenticatedControllerInterface
{
    public function __construct(
        private readonly EnvironmentServiceInterface $envService,
        private readonly EnvironmentRenderer $environmentRenderer,
    ) {
    }

    #[Route(
        path: '/env',
        methods: [Request::METHOD_GET],
    )]
    public function env(AuthCredentials $credentials, ConnectorConfig $connectorConfig): Response
    {
        $envResult = $this->envService->getEnvironments($credentials, $connectorConfig);

        return $this->environmentRenderer->render($envResult);
    }
}
