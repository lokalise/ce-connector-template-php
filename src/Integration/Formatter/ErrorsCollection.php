<?php

namespace App\Integration\Formatter;

use App\DTO\BaseErrorInfo;
use App\Formatter\AbstractErrorsCollection;
use Symfony\Component\Validator\ConstraintViolationInterface;

class ErrorsCollection extends AbstractErrorsCollection
{
    public function addError(ConstraintViolationInterface $violation): void
    {
        $this->empty = false;
    }

    /**
     * @return array<int, BaseErrorInfo>
     */
    public function getErrors(): array
    {
        return [];
    }
}
