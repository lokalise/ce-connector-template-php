<?php

namespace App\Formatter;

use App\DTO\CustomErrorInfo;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class BadRequestErrorsFormatter implements ErrorsFormatterInterface
{
    /**
     * @return array<int, CustomErrorInfo>
     */
    public function format(ConstraintViolationListInterface $violations): array
    {
        $errors = new CustomErrorInfo();

        foreach ($violations as $violation) {
            $errors->addError($violation->getPropertyPath(), $violation->getMessage());
        }

        return [$errors];
    }
}
