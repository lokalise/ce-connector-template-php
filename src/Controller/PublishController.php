<?php

namespace App\Controller;

use App\DTO\Request\PublishRequest;
use App\DTO\Token;
use App\Exception\AccessDeniedException;
use App\Interfaces\Renderer\PublishRendererInterface;
use App\Interfaces\Service\PublishServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Annotation\Route;

class PublishController extends AbstractController implements TokenAuthenticatedControllerInterface
{
    public function __construct(
        private readonly PublishServiceInterface $publishService,
        private readonly PublishRendererInterface $publishRenderer,
    ) {
    }

    #[Route(
        path: '/publish',
        methods: [Request::METHOD_POST]
    )]
    public function publish(Token $token, PublishRequest $publishRequest): Response
    {
        try {
            $this->publishService->publishContent($token->value, $publishRequest->items);

            return $this->publishRenderer->render();
        } catch (AccessDeniedException) {
            throw new AccessDeniedHttpException('Could not publish content');
        }
    }
}
