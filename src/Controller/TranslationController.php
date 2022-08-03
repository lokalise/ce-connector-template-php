<?php

namespace App\Controller;

use App\DTO\Request\TranslateRequest;
use App\DTO\Token;
use App\Exception\AccessDeniedException;
use App\Interfaces\Renderer\TranslationRendererInterface;
use App\Interfaces\Service\TranslationServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Annotation\Route;

class TranslationController extends AbstractController implements TokenAuthenticatedControllerInterface
{
    public function __construct(
        private readonly TranslationServiceInterface $translationService,
        private readonly TranslationRendererInterface $translationRenderer,
    ) {
    }

    #[Route(
        path: '/translate',
        methods: [Request::METHOD_POST]
    )]
    public function translate(Token $token, TranslateRequest $translateRequest): Response
    {
        try {
            $items = $this->translationService->getTranslations(
                $token->value,
                $translateRequest->locales,
                $translateRequest->items,
            );

            return $this->translationRenderer->render($items);
        } catch (AccessDeniedException) {
            throw new AccessDeniedHttpException('Could not retrieve content items');
        }
    }
}
