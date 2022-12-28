<?php

namespace App\Controller;

use App\DTO\Request\CacheRequest;
use App\Integration\DTO\AuthCredentials;
use App\Integration\DTO\ConnectorConfig;
use App\Interfaces\Service\CacheServiceInterface;
use App\Renderer\CacheItemRenderer;
use App\Renderer\CacheRenderer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/v2')]
class CacheController extends AbstractController implements AuthenticatedControllerInterface
{
    public function __construct(
        private readonly CacheServiceInterface $cacheService,
        private readonly CacheRenderer $cacheRenderer,
        private readonly CacheItemRenderer $cacheItemRenderer,
    ) {
    }

    #[Route(
        path: '/cache',
        methods: [Request::METHOD_GET],
    )]
    public function cache(AuthCredentials $credentials, ConnectorConfig $connectorConfig): Response
    {
        $cacheResult = $this->cacheService->getCache($credentials, $connectorConfig);

        return $this->cacheRenderer->render($cacheResult);
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
        $identifiersList = $this->cacheService->getCacheItems($credentials, $connectorConfig, $cacheRequest->items);

        return $this->cacheItemRenderer->render($identifiersList);
    }
}
