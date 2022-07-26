<?php

namespace App\Controller;

use App\DTO\Request\PublishRequest;
use App\DTO\Response\PublishResponse;
use App\Interfaces\PublishInterface;
use App\TokenExtractor\TokenExtractorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Annotation\Route;

class PublishController extends AbstractController
{
    public function __construct(
        private readonly TokenExtractorInterface $tokenExtractor,
        private readonly PublishInterface $publishService,
    ) {
    }

    #[Route(
        path: '/publish',
        methods: [Request::METHOD_POST]
    )]
    public function publish(Request $request, PublishRequest $publishRequest): JsonResponse
    {
        $accessToken = $this->tokenExtractor->extract($request);
        if (!$accessToken) {
            return $this->json([]);
        }

        $publishResult = $this->publishService->publishContent($accessToken, $publishRequest->items);
        if (!$publishResult) {
            throw new AccessDeniedHttpException('Could not publish content');
        }

        $responseDTO = new PublishResponse(Response::HTTP_OK, 'Content successfully updated');

        return $this->json($responseDTO);
    }
}
