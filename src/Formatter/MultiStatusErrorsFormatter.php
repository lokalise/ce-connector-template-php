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
            $errors[] = [
                $violation->getPropertyPath() => new ErrorItem($violation->getMessage()),
            ];
        }

        return $errors;
    }
}
