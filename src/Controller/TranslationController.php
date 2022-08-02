<?php

namespace App\Controller;

use App\DTO\Request\TranslateRequest;
use App\DTO\Response\TranslationResponse;
use App\DTO\Token;
use App\Interfaces\TranslationInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Annotation\Route;

class TranslationController extends AbstractController implements TokenAuthenticatedControllerInterface
{
    public function __construct(
        private readonly TranslationInterface $translationService,
    ) {
    }

    #[Route(
        path: '/translate',
        methods: [Request::METHOD_POST]
    )]
    public function translate(Token $token, TranslateRequest $translateRequest): JsonResponse
    {
        $items = $this->translationService->getContent(
            $token->value,
            $translateRequest->locales,
            $translateRequest->items,
        );

        if (!$items) {
            throw new AccessDeniedHttpException('Could not retrieve content items');
        }

        $responseDTO = new TranslationResponse($items);

        return $this->json($responseDTO);
    }
}
