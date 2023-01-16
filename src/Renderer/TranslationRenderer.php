<?php

namespace App\Renderer;

use App\DTO\Response\TranslationResponse;
use App\DTO\TranslationItem;
use Symfony\Component\HttpFoundation\Response;

class TranslationRenderer
{
    public function __construct(
        private readonly JsonResponseRenderer $jsonResponseRenderer,
    ) {
    }

    /**
     * @param array<int, TranslationItem> $items
     */
    public function render(array $items): Response
    {
        $responseDTO = new TranslationResponse($items);

        return $this->jsonResponseRenderer->render($responseDTO);
    }
}
