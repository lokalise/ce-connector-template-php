<?php

namespace App\Exception;

use App\DTO\ErrorDetails\ErrorDetailsDTO;
use App\Enum\ErrorCodeEnum;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException as BaseHttpException;

class HttpException extends BaseHttpException
{
    public function __construct(
        private readonly ErrorCodeEnum $errorCode = ErrorCodeEnum::UNKNOWN_ERROR,
        private readonly ?ErrorDetailsDTO $details = null,
        string $message = '',
        int $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR,
    ) {
        parent::__construct($statusCode, $message);
    }

    public function getErrorCode(): ErrorCodeEnum
    {
        return $this->errorCode;
    }

    public function getDetails(): ?ErrorDetailsDTO
    {
        return $this->details;
    }
}
