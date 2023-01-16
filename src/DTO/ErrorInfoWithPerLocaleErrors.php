<?php

namespace App\DTO;

class ErrorInfoWithPerLocaleErrors extends BaseErrorInfo
{
    /**
     * @param array<string, PerLocaleError> $perLocaleErrors
     */
    public function __construct(
        string $uniqueId,
        public readonly array $perLocaleErrors,
    ) {
        parent::__construct($uniqueId);
    }
}
