<?php

namespace App\Controller;

use App\DTO\Request\AuthenticationRequest;
use App\DTO\Request\RefreshRequest;
use App\DTO\Response\AuthResponse;
use App\DTO\Response\RefreshResponse;
use App\Interfaces\AuthenticationInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Annotation\Route;

class AuthenticationController extends AbstractController
{
    public function __construct(
        private readonly AuthenticationInterface $authenticationService,
    ) {
    }

    #[Route(
        path: '/auth',
        methods: [Request::METHOD_POST],
    )]
    public function auth(AuthenticationRequest $authenticationRequest): JsonResponse
    {
        $key = $this->authenticationService->validate($authenticationRequest->key);

        if (!$key) {
            throw new AccessDeniedHttpException('Could not authenticate to 3rd party using the provided key.');
        }

        $responseDTO = new AuthResponse($key);

        return $this->json($responseDTO);
    }

    #[Route(
        path: '/auth/refresh',
        methods: [Request::METHOD_POST],
    )]
    public function refresh(RefreshRequest $refreshRequest): JsonResponse
    {
        $refreshKey = $this->authenticationService->refresh($refreshRequest->refreshKey);

        if (!$refreshKey) {
            throw new AccessDeniedHttpException('Could not authenticate to 3rd party using the provided key.');
        }

        $responseDTO = new RefreshResponse($refreshKey);

        return $this->json($responseDTO);
    }
}
