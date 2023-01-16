<?php

namespace App\Exception;

use App\DTO\BaseErrorInfo;
use App\DTO\CustomErrorInfo;
use App\DTO\Identifier;
use App\Enum\ErrorCodeEnum;
use Symfony\Component\HttpFoundation\Response;

class MultiStatusHttpException extends HttpException
{
    /**
     * @param array<int, BaseErrorInfo|CustomErrorInfo> $errors
     * @param array<int, Identifier> $items
     */
    public function __construct(
        string $message = '',
        array $errors = [],
        ErrorCodeEnum $errorCode = ErrorCodeEnum::SOME_ITEMS_HAVE_ERRORS,
        private readonly ?array $items = null,
    ) {
        parent::__construct($message, Response::HTTP_MULTI_STATUS, $errorCode, $errors);
    }

    /**
     * @return array<int, Identifier>|null
     */
    public function getItems(): ?array
    {
        return $this->items;
    }
}
