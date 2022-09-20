<?php

namespace App\Renderer;

use App\DTO\ErrorItem;
use App\DTO\Response\PublishResponse;
use Symfony\Component\HttpFoundation\Response;

class PublishRenderer
{
    public function __construct(
        private readonly JsonResponseRenderer $jsonResponseRenderer,
    ) {
    }

    /**
     * @param array<int, array<string, ErrorItem>> $errors
     */
    public function render(?string $errorMessage = null, array $errors = []): Response
    {
        $responseDTO = new PublishResponse(Response::HTTP_OK, 'Content successfully updated');

        return $this->jsonResponseRenderer->render($responseDTO, $errorMessage, $errors);
    }
}
