<?php

namespace App\Formatter;

use App\DTO\BaseErrorInfo;
use App\DTO\CustomErrorInfo;
use App\DTO\UnrecognizedError;
use Symfony\Component\Validator\ConstraintViolationListInterface;

interface ErrorsFormatterInterface
{
    /**
     * @return array<int, BaseErrorInfo|CustomErrorInfo|UnrecognizedError>
     */
    public function format(ConstraintViolationListInterface $violations): array;
}
