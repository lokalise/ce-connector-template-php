<?php

namespace App\Controller;

use App\DTO\Request\CacheRequest;
use App\DTO\Response\CacheItemsResponse;
use App\DTO\Response\CacheResponse;
use App\Interfaces\CacheInterface;
use App\TokenExtractor\TokenExtractorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class CacheController extends AbstractController
{
    public function __construct(
        private readonly TokenExtractorInterface $tokenExtractor,
        private readonly CacheInterface $cacheService,
    ) {
    }

    #[Route(
        path: '/cache',
        methods: [Request::METHOD_GET],
    )]
    public function index(Request $request): JsonResponse
    {
        $accessToken = $this->tokenExtractor->extract($request);

        if (!$accessToken) {
            throw new AccessDeniedHttpException('Not authorised');
        }

        $cacheResult =$this->cacheService->listItems($accessToken);

        $responseDTO = new CacheResponse($cacheResult);

        return $this->json($responseDTO);
    }

    #[Route(
        path: '/cache/items',
        methods: [Request::METHOD_POST],
    )]
    public function items(Request $request, CacheRequest $cacheRequest): JsonResponse
    {
        $accessToken = $this->tokenExtractor->extract($request);

        if (!$accessToken) {
            throw new AccessDeniedHttpException('Not authorised');
        }

        $cacheResult =$this->cacheService->getItems($accessToken, $cacheRequest->items);

        $responseDTO = new CacheItemsResponse($cacheResult);

        return $this->json($responseDTO);
    }
}
