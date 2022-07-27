<?php

namespace App\Controller;

use App\DTO\Request\TranslateRequest;
use App\DTO\Response\TranslationResponse;
use App\Interfaces\TranslationInterface;
use App\TokenExtractor\TokenExtractorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Annotation\Route;

class TranslationController extends AbstractController implements TokenAuthenticatedControllerInterface
{
    public function __construct(
        private readonly TokenExtractorInterface $tokenExtractor,
        private readonly TranslationInterface $translationService,
    ) {
    }

    #[Route(
        path: '/translate',
        methods: [Request::METHOD_POST]
    )]
    public function translate(Request $request, TranslateRequest $translateRequest): JsonResponse
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

        $responseDTO = new TranslationResponse($items);;

        return $this->json($responseDTO);
    }
}
