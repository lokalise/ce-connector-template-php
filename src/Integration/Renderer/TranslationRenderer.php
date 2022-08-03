<?php

namespace App\Integration\Renderer;

use App\DTO\ContentItem;
use App\DTO\Response\TranslationResponse;
use App\Interfaces\Renderer\TranslationRendererInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class TranslationRenderer implements TranslationRendererInterface
{
    /**
     * @param array<int, ContentItem> $items
     */
    public function render(array $items): Response
    {
        $responseDTO = new TranslationResponse($items);

        return new JsonResponse($responseDTO);
    }
}