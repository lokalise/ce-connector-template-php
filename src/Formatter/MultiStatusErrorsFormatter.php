<?php

namespace App\Formatter;

use App\DTO\BaseErrorInfo;
use App\DTO\CustomErrorInfo;
use App\Integration\Formatter\ErrorsCollection;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class MultiStatusErrorsFormatter implements ErrorsFormatterInterface
{
    /**
     * @return array<int, BaseErrorInfo|CustomErrorInfo>
     */
    public function format(ConstraintViolationListInterface $violations): array
    {
        $errorsCollection = new ErrorsCollection();

        foreach ($violations as $violation) {
            $errorsCollection->addError($violation);
        }

        return $errorsCollection->getErrors();
    }
}
