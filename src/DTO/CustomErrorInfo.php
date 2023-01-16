<?php

namespace App\DTO;

class CustomErrorInfo implements \JsonSerializable
{
    /**
     * @param array<string, array<int, string>> $customErrors
     */
    public function __construct(
        private array $customErrors = [],
    ) {
    }

    public function addError(string $key, string $error): void
    {
        $this->customErrors[$key][] = $error;
    }

    public function jsonSerialize(): array
    {
        return $this->customErrors;
    }
}
