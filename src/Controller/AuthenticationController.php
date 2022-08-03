<?php

namespace App\Controller;

use App\DTO\Request\AuthenticationRequest;
use App\DTO\Request\RefreshRequest;
use App\Exception\AccessDeniedException;
use App\Interfaces\Renderer\AuthRendererInterface;
use App\Interfaces\Renderer\RefreshRendererInterface;
use App\Interfaces\Service\AuthenticationServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Annotation\Route;

class AuthenticationController extends AbstractController
{
    public function __construct(
        private readonly AuthenticationServiceInterface $authenticationService,
        private readonly AuthRendererInterface $authRenderer,
        private readonly RefreshRendererInterface $refreshRenderer,
    ) {
    }

    #[Route(
        path: '/auth',
        methods: [Request::METHOD_POST],
    )]
    public function auth(AuthenticationRequest $authenticationRequest): Response
    {
        try {
            $key = $this->authenticationService->auth($authenticationRequest->key);

            return $this->authRenderer->render($key);
        } catch (AccessDeniedException) {
            throw new AccessDeniedHttpException('Could not authenticate to 3rd party using the provided key.');
        }
    }

    #[Route(
        path: '/auth/refresh',
        methods: [Request::METHOD_POST],
    )]
    public function refresh(RefreshRequest $refreshRequest): Response
    {
        try {
            $refreshKey = $this->authenticationService->refresh($refreshRequest->refreshKey);

            return $this->refreshRenderer->render($refreshKey);
        } catch (AccessDeniedException) {
            throw new AccessDeniedHttpException('Could not authenticate to 3rd party using the provided key.');
        }
    }
}
