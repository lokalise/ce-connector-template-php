<?php

namespace App\Controller;

use App\DTO\Response\EnvironmentResponse;
use App\DTO\Token;
use App\Interfaces\EnvironmentInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class EnvironmentController extends AbstractController implements TokenAuthenticatedControllerInterface
{
    public function __construct(
        private readonly EnvironmentInterface $envService,
    ) {
    }

    #[Route(
        path: '/env',
        methods: [Request::METHOD_GET],
    )]
    public function index(Token $token): JsonResponse
    {
        $envResult = $this->envService->getEnv($token->value);

        if (!$envResult) {
            throw new AccessDeniedHttpException('Could not retrieve content items');
        }

        $responseDTO = new EnvironmentResponse($envResult);

        return $this->json($responseDTO);
    }
}
