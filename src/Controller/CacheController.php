<?php

namespace App\Controller;

use App\DTO\Request\CacheRequest;
use App\DTO\Response\CacheItemsResponse;
use App\DTO\Response\CacheResponse;
use App\DTO\Token;
use App\Interfaces\CacheInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Annotation\Route;

class CacheController extends AbstractController implements TokenAuthenticatedControllerInterface
{
    public function __construct(
        private readonly CacheInterface $cacheService,
    ) {
    }

    #[Route(
        path: '/cache',
        methods: [Request::METHOD_GET],
    )]
    public function index(Token $token): JsonResponse
    {
        $cacheResult = $this->cacheService->listItems($token->value);

        if (!$cacheResult) {
            throw new AccessDeniedHttpException('Could not retrieve content items');
        }

        $responseDTO = new CacheResponse($cacheResult);

        return $this->json($responseDTO);
    }

    #[Route(
        path: '/cache/items',
        methods: [Request::METHOD_POST],
    )]
    public function items(Token $token, CacheRequest $cacheRequest): JsonResponse
    {
        $cacheResult = $this->cacheService->getItems($token->value, $cacheRequest->items);

        if (!$cacheResult) {
            throw new AccessDeniedHttpException('Could not retrieve content items');
        }

        $responseDTO = new CacheItemsResponse($cacheResult);

        return $this->json($responseDTO);
    }
}
