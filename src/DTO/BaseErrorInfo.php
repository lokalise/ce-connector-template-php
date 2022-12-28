<?php

namespace App\DTO;

abstract class BaseErrorInfo
{
    public function __construct(
        public readonly string $uniqueId,
    ) {
    }
}
