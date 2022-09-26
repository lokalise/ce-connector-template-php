<?php

namespace App\Controller;

use App\DTO\Request\TranslateRequest;
use App\Exception\AccessDeniedException;
use App\Integration\DTO\AuthCredentials;
use App\Integration\DTO\ConnectorConfig;
use App\Interfaces\Renderer\TranslationRendererInterface;
use App\Interfaces\Service\TranslationServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/v2')]
class TranslationController extends AbstractController implements AuthenticatedControllerInterface
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
    public function translate(
        AuthCredentials $credentials,
        ConnectorConfig $connectorConfig,
        TranslateRequest $translateRequest,
    ): Response {
        try {
            $items = $this->translationService->getTranslations(
                $credentials,
                $connectorConfig,
                $translateRequest->locales,
                $translateRequest->items,
                $translateRequest->defaultLocale
            );

            return $this->translationRenderer->render($items);
        } catch (AccessDeniedException) {
            throw new AccessDeniedHttpException('Could not retrieve content items');
        }
    }
}
