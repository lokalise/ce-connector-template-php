<?php

namespace App\DTO;

class ErrorInfoWithUserErrors extends BaseErrorInfo
{
    /**
     * @param array<int, string> $userErrors
     */
    public function __construct(
        string $uniqueId,
        public readonly array $userErrors = [],
    ) {
        parent::__construct($uniqueId);
    }
}
