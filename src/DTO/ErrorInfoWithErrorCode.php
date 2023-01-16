<?php

namespace App\DTO;

use App\Enum\SingleItemErrorCodeEnum;

class ErrorInfoWithErrorCode extends BaseErrorInfo
{
    public function __construct(
        string $uniqueId,
        public readonly SingleItemErrorCodeEnum $errorCode,
    ) {
        parent::__construct($uniqueId);
    }
}
