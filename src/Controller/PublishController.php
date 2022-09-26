<?php

namespace App\Controller;

use App\DTO\Request\PublishRequest;
use App\Exception\AccessDeniedException;
use App\Integration\DTO\AuthCredentials;
use App\Integration\DTO\ConnectorConfig;
use App\Interfaces\Renderer\PublishRendererInterface;
use App\Interfaces\Service\PublishServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/v2')]
class PublishController extends AbstractController implements AuthenticatedControllerInterface
{
    public function __construct(
        private readonly PublishServiceInterface $publishService,
        private readonly PublishRendererInterface $publishRenderer,
    ) {
    }

    #[Route(
        path: '/publish',
        methods: [Request::METHOD_POST]
    )]
    public function publish(
        AuthCredentials $credentials,
        ConnectorConfig $connectorConfig,
        PublishRequest $publishRequest,
    ): Response {
        try {
            $this->publishService->publishContent(
                $credentials,
                $connectorConfig,
                $publishRequest->items,
                $publishRequest->defaultLocale,
            );

            return $this->publishRenderer->render();
        } catch (AccessDeniedException) {
            throw new AccessDeniedHttpException('Could not publish content');
        }
    }
}
