<?php

namespace App\Renderer;

use App\DTO\ErrorDetails;
use App\Exception\HttpException;
use App\Exception\UnauthorizedHttpException;

class UnauthorizedErrorRenderer extends ErrorRenderer
{
    protected function createDetails(UnauthorizedHttpException|HttpException $exception): ?ErrorDetails
    {
        return $exception->getError() ? new ErrorDetails(error: $exception->getError()) : null;
    }
}
