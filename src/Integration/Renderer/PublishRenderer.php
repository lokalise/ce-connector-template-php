<?php

namespace App\Integration\Renderer;

use App\DTO\Response\PublishResponse;
use App\Interfaces\Renderer\PublishRendererInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class PublishRenderer implements PublishRendererInterface
{
    public function render(): Response
    {
        $responseDTO = new PublishResponse(Response::HTTP_OK, 'Content successfully updated');

        return new JsonResponse($responseDTO);
    }
}
