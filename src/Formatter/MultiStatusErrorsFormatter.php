<?php

namespace App\Formatter;

use App\DTO\ErrorItem;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class MultiStatusErrorsFormatter
{
    /**
     * @return array<int, array<string, ErrorItem>>
     */
    public function format(ConstraintViolationListInterface $violations): array
    {
        $errors = [];

        foreach ($violations as $violation) {
            $uniqueId = $violation->getCause();
            $fieldPath = $violation->getPropertyPath();

            $errorItem = new ErrorItem(
                $violation->getInvalidValue(),
                $violation->getMessage(),
                $violation->getCode(),
            );

            if ('uniqueId' === $fieldPath) {
                $errors[$uniqueId]['uniqueId'] = $errorItem;
            } else {
                $errors[$uniqueId]['uniqueId'] = $uniqueId;
                $errors[$uniqueId]['translations'][$fieldPath] = $errorItem;
            }
        }

        return array_values($errors);
    }
}
