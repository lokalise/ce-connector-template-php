<?php

namespace App\Controller;

use App\DTO\Request\PublishRequest;
use App\DTO\Response\PublishResponse;
use App\DTO\Token;
use App\Interfaces\PublishInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Annotation\Route;

class PublishController extends AbstractController implements TokenAuthenticatedControllerInterface
{
    public function __construct(
        private readonly PublishInterface $publishService,
    ) {
    }

    #[Route(
        path: '/publish',
        methods: [Request::METHOD_POST]
    )]
    public function publish(Token $token, PublishRequest $publishRequest): JsonResponse
    {
        $publishResult = $this->publishService->publishContent($token->value, $publishRequest->items);

        if (!$publishResult) {
            throw new AccessDeniedHttpException('Could not publish content');
        }

        $responseDTO = new PublishResponse(Response::HTTP_OK, 'Content successfully updated');

        return $this->json($responseDTO);
    }
}
