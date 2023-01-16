<?php

namespace App\Exception;

use App\DTO\BaseErrorInfo;
use App\DTO\CustomErrorInfo;
use App\DTO\UnrecognizedError;
use App\Enum\ErrorCodeEnum;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException as BaseHttpException;

class HttpException extends BaseHttpException
{
    /**
     * @param array<int, BaseErrorInfo|CustomErrorInfo|UnrecognizedError>|null $errors
     */
    public function __construct(
        string $message = 'Unrecognized error',
        int $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR,
        private readonly ErrorCodeEnum $errorCode = ErrorCodeEnum::UNRECOGNIZED_ERROR,
        private readonly ?array $errors = null,
    ) {
        parent::__construct($statusCode, $message);
    }

    public function getErrorCode(): ErrorCodeEnum
    {
        return $this->errorCode;
    }

    /**
     * @return array<int, BaseErrorInfo|CustomErrorInfo|UnrecognizedError>|null
     */
    public function getErrors(): ?array
    {
        return $this->errors;
    }
}
