<?php

namespace App\Renderer;

use App\DTO\Response\ErrorResponse;
use App\Exception\HttpException;
use App\Exception\MultiStatusHttpException;

class MultiStatusErrorRenderer extends ErrorRenderer
{
    public function render(MultiStatusHttpException|HttpException $exception): ErrorResponse
    {
        return new ErrorResponse(
            $exception->getStatusCode(),
            $this->createPayload($exception),
            $exception->getItems(),
        );
    }
}
