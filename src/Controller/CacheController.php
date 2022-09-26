<?php

namespace App\Controller;

use App\DTO\Request\CacheRequest;
use App\Exception\AccessDeniedException;
use App\Integration\DTO\AuthCredentials;
use App\Integration\DTO\ConnectorConfig;
use App\Interfaces\Renderer\CacheItemRendererInterface;
use App\Interfaces\Renderer\CacheRendererInterface;
use App\Interfaces\Service\CacheServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/v2')]
class CacheController extends AbstractController implements AuthenticatedControllerInterface
{
    public function __construct(
        private readonly CacheServiceInterface $cacheService,
        private readonly CacheRendererInterface $cacheRenderer,
        private readonly CacheItemRendererInterface $cacheItemRenderer,
    ) {
    }

    #[Route(
        path: '/cache',
        methods: [Request::METHOD_GET],
    )]
    public function cache(AuthCredentials $credentials, ConnectorConfig $connectorConfig): Response
    {
        try {
            $cacheResult = $this->cacheService->getCache($credentials, $connectorConfig);

            return $this->cacheRenderer->render($cacheResult);
        } catch (AccessDeniedException) {
            throw new AccessDeniedHttpException('Could not retrieve content items');
        }
    }

    #[Route(
        path: '/cache/items',
        methods: [Request::METHOD_POST],
    )]
    public function cacheItems(
        AuthCredentials $credentials,
        ConnectorConfig $connectorConfig,
        CacheRequest $cacheRequest,
    ): Response {
        try {
            $cacheResult = $this->cacheService->getCacheItems($credentials, $connectorConfig, $cacheRequest->items);

            return $this->cacheItemRenderer->render($cacheResult);
        } catch (AccessDeniedException) {
            throw new AccessDeniedHttpException('Could not retrieve content items');
        }
    }
}
