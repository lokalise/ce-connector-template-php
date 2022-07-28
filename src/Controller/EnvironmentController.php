<?php

namespace App\Controller;

use App\DTO\Response\EnvironmentResponse;
use App\Interfaces\EnvironmentInterface;
use App\TokenExtractor\TokenExtractorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class EnvironmentController extends AbstractController implements TokenAuthenticatedControllerInterface
{
    public function __construct(
        private readonly TokenExtractorInterface $tokenExtractor,
        private readonly EnvironmentInterface $envService,
    ) {
    }

    #[Route(
        path: '/env',
        methods: [Request::METHOD_GET],
    )]
    public function env(Request $request): JsonResponse
    {
        $accessToken = $this->tokenExtractor->extract($request);

        $envResult = $this->envService->getEnv($accessToken);

        if (!$envResult) {
            throw new AccessDeniedHttpException('Could not retrieve content items');
        }

        $responseDTO = new EnvironmentResponse($envResult);

        return $this->json($responseDTO);
    }
}
