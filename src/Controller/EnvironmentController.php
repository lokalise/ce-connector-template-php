<?php

namespace App\Controller;

use App\DTO\Token;
use App\Exception\AccessDeniedException;
use App\Interfaces\Renderer\EnvironmentRendererInterface;
use App\Interfaces\Service\EnvironmentServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Annotation\Route;

class EnvironmentController extends AbstractController implements TokenAuthenticatedControllerInterface
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
    public function env(Token $token): Response
    {
        try {
            $envResult = $this->envService->getEnvironments($token->value);

            return $this->environmentRenderer->render($envResult);
        } catch (AccessDeniedException) {
            throw new AccessDeniedHttpException('Could not retrieve content items');
        }
    }
}
