<?php

namespace App\Renderer;

use App\DTO\Response\PublishResponse;
use Symfony\Component\HttpFoundation\Response;

class PublishRenderer
{
    public function __construct(
        private readonly JsonResponseRenderer $jsonResponseRenderer,
    ) {
    }

    public function render(): Response
    {
        $responseDTO = new PublishResponse(Response::HTTP_OK, 'Content successfully updated');

        return $this->jsonResponseRenderer->render($responseDTO);
    }
}
