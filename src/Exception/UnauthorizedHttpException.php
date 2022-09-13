<?php

namespace App\Exception;

use App\DTO\ErrorDetails\ErrorDetailsDTO;
use App\Enum\ErrorCodeEnum;
use Symfony\Component\HttpFoundation\Response;

class UnauthorizedHttpException extends HttpException
{
    public function __construct(
        string $message = 'Unauthorized',
        ?ErrorDetailsDTO $details = null,
        ErrorCodeEnum $errorCode = ErrorCodeEnum::AUTH_FAILED_ERROR,
    ) {
        parent::__construct($errorCode, $details, $message, Response::HTTP_UNAUTHORIZED);
    }
}
