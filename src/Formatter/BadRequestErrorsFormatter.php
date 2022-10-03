<?php

namespace App\Formatter;

use Symfony\Component\Validator\ConstraintViolationListInterface;

class BadRequestErrorsFormatter
{
    /**
     * @return array<string, array<int, string>>
     */
    public function format(ConstraintViolationListInterface $violations): array
    {
        $errors = [];

        foreach ($violations as $violation) {
            if (!isset($errors[$violation->getPropertyPath()])) {
                $errors[$violation->getPropertyPath()] = [];
            }

            $errors[$violation->getPropertyPath()][] = $violation->getMessage();
        }

        return $errors;
    }
}
