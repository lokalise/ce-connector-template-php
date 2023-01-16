<?php

namespace App\Formatter;

use App\DTO\BaseErrorInfo;
use Symfony\Component\Validator\ConstraintViolationInterface;

interface ErrorsCollectionInterface
{
    public function addError(ConstraintViolationInterface $violation): void;

    /**
     * @return array<int, BaseErrorInfo>
     */
    public function getErrors(): array;

    public function isEmpty(): bool;
}
