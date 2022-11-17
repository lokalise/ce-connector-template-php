<?php

namespace App\Controller;

use App\DTO\Request\TranslateRequest;
use App\Integration\DTO\AuthCredentials;
use App\Integration\DTO\ConnectorConfig;
use App\Interfaces\Service\TranslationServiceInterface;
use App\Renderer\TranslationRenderer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/v2')]
class TranslationController extends AbstractController implements AuthenticatedControllerInterface
{
    public function __construct(
        private readonly TranslationServiceInterface $translationService,
        private readonly TranslationRenderer $translationRenderer,
    ) {
    }

    #[Route(
        path: '/translate',
        methods: [Request::METHOD_POST],
    )]
    public function translate(
        AuthCredentials $credentials,
        ConnectorConfig $connectorConfig,
        TranslateRequest $translateRequest,
    ): Response {
        $identifiersList = $this->translationService->getTranslations(
            $credentials,
            $connectorConfig,
            $translateRequest->locales,
            $translateRequest->items,
            $translateRequest->defaultLocale,
        );

        return $this->translationRenderer->render(
            $identifiersList->items,
            $identifiersList->errorMessage,
            $identifiersList->errors,
        );
    }
}
