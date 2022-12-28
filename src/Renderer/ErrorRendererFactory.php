<?php

namespace App\Renderer;

use App\Exception\HttpException;
use App\Exception\MultiStatusHttpException;
use App\Exception\UnauthorizedHttpException;

class ErrorRendererFactory
{
    public function __construct(
        private readonly ErrorRenderer $errorRenderer,
        private readonly MultiStatusErrorRenderer $multiStatusErrorRenderer,
        private readonly UnauthorizedErrorRenderer $unauthorizedErrorRenderer,
    ) {
    }

    public function factory(HttpException $exception): ErrorRenderer
    {
        return match (true) {
            $exception instanceof MultiStatusHttpException => $this->multiStatusErrorRenderer,
            $exception instanceof UnauthorizedHttpException => $this->unauthorizedErrorRenderer,
            default => $this->errorRenderer,
        };
    }
}
