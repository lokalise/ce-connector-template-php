<?php

namespace App\Renderer;

use App\DTO\ErrorDetails;
use App\DTO\ErrorPayload;
use App\DTO\Response\ErrorResponse;
use App\Exception\HttpException;

class ErrorRenderer
{
    protected function createDetails(HttpException $exception): ?ErrorDetails
    {
        return !empty($exception->getErrors()) ? new ErrorDetails($exception->getErrors()) : null;
    }

    protected function createPayload(HttpException $exception): ErrorPayload
    {
        return new ErrorPayload(
            $exception->getMessage(),
            $exception->getErrorCode(),
            $this->createDetails($exception),
        );
    }

    public function render(HttpException $exception): ErrorResponse
    {
        return new ErrorResponse(
            $exception->getStatusCode(),
            $this->createPayload($exception),
        );
    }
}
