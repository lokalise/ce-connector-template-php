<?php

namespace App\Exception;

use App\Enum\ErrorCodeEnum;
use Symfony\Component\HttpFoundation\Response;

class UnauthorizedHttpException extends HttpException
{
    public function __construct(
        string $message = 'Authorization failed',
        ErrorCodeEnum $errorCode = ErrorCodeEnum::AUTH_FAILED_ERROR,
        private readonly ?string $error = null,
    ) {
        parent::__construct($message, Response::HTTP_UNAUTHORIZED, $errorCode);
    }

    public function getError(): ?string
    {
        return $this->error;
    }
}
