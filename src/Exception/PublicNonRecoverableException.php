<?php

namespace App\Exception;

use App\Enum\ErrorCodeEnum;
use Symfony\Component\HttpKernel\Exception\HttpException as BaseHttpException;

class PublicNonRecoverableException extends BaseHttpException
{
    public function __construct(
        int $statusCode,
        string $message = '',
        \Throwable $previous = null,
        array $headers = [],
        int $code = 0,
        private readonly ErrorCodeEnum $errorCode = ErrorCodeEnum::UNKNOWN_ERROR,
        private readonly array $details = [],
    ) {
        parent::__construct($statusCode, $message, $previous, $headers, $code);
    }

    public function getErrorCode(): ErrorCodeEnum
    {
        return $this->errorCode;
    }

    public function getDetails(): array
    {
        return $this->details;
    }
}
