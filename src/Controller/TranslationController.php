<?php

namespace App\Controller;

use App\DTO\Request\TranslateRequest;
use App\Interfaces\TranslationInterface;
use App\Interfaces\TranslationRendererInterface;
use App\TokenExtractor\TokenExtractorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Annotation\Route;

class TranslationController extends AbstractController implements TokenAuthenticatedController
{
    public function __construct(
        private readonly TokenExtractorInterface $tokenExtractor,
        private readonly TranslationInterface $translationService,
        private readonly TranslationRendererInterface $translationRenderer,
    ) {
    }

    #[Route(
        path: '/translate',
        methods: [Request::METHOD_POST]
    )]
    public function publish(Request $request, TranslateRequest $translateRequest): JsonResponse
    {
        $accessToken = $this->tokenExtractor->extract($request);

        $items = $this->translationService->getContent(
            $accessToken,
            $translateRequest->locales,
            $translateRequest->items,
        );
        if (!$items) {
            throw new AccessDeniedHttpException('Could not retrieve content items');
        }

        $responseDTO = $this->translationRenderer->render($items);

        return $this->json($responseDTO);
    }
}
