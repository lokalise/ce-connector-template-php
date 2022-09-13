<?php

namespace App\Renderer;

use App\DTO\ErrorItem;
use App\DTO\TranslationItem;
use App\DTO\Response\TranslationResponse;
use App\DTO\TranslationItem;
use App\Interfaces\Renderer\TranslationRendererInterface;
use Symfony\Component\HttpFoundation\Response;

class TranslationRenderer implements TranslationRendererInterface
{
    public function __construct(
        private readonly JsonResponseRenderer $jsonResponseRenderer,
    ) {
    }

    /**
     * @param array<int, TranslationItem> $items
     * @param array<int, array<string, ErrorItem>> $errors
     */
    public function render(array $items, ?string $errorMessage = null, array $errors = []): Response
    {
        $responseDTO = new TranslationResponse($items);

        return $this->jsonResponseRenderer->render($responseDTO, $errorMessage, $errors);
    }
}
