<?php

namespace App\Exception;

use App\DTO\CustomErrorInfo;
use App\Enum\ErrorCodeEnum;
use Symfony\Component\HttpFoundation\Response;

class BadRequestHttpException extends HttpException
{
    /**
     * @param array<int, CustomErrorInfo> $errors
     */
    public function __construct(
        string $message = '',
        array $errors = [],
        ErrorCodeEnum $errorCode = ErrorCodeEnum::UNRECOGNIZED_ERROR,
    ) {
        parent::__construct($message, Response::HTTP_BAD_REQUEST, $errorCode, $errors);
    }
}
