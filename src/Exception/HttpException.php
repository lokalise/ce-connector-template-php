<?php

namespace App\Exception;

use App\DTO\ErrorDetails;
use App\Enum\ErrorCodeEnum;
use App\Integration\DTO\UnknownErrorDetails;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException as BaseHttpException;

class HttpException extends BaseHttpException
{
    public function __construct(
        private readonly ErrorCodeEnum $errorCode = ErrorCodeEnum::UNKNOWN_ERROR,
        private readonly ErrorDetails $details = new UnknownErrorDetails(),
        string $message = '',
        int $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR,
    ) {
        parent::__construct($statusCode, $message, null, [], 0);
    }

    public function getErrorCode(): ErrorCodeEnum
    {
        return $this->errorCode;
    }

    public function getDetails(): ErrorDetails
    {
        return $this->details;
    }
}
