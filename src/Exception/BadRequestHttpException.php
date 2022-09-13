<?php

namespace App\Exception;

use App\DTO\ErrorDetails\ErrorDetailsDTO;
use App\Enum\ErrorCodeEnum;
use Symfony\Component\HttpFoundation\Response;

class BadRequestHttpException extends HttpException
{
    public function __construct(
        string $message = '',
        ?ErrorDetailsDTO $details = null,
        ErrorCodeEnum $errorCode = ErrorCodeEnum::AUTH_INVALID_DATA_ERROR,
    ) {
        parent::__construct($errorCode, $details, $message, Response::HTTP_BAD_REQUEST);
    }
}
