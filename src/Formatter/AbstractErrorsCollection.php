<?php

namespace App\Formatter;

abstract class AbstractErrorsCollection implements ErrorsCollectionInterface
{
    protected bool $empty = true;

    public function isEmpty(): bool
    {
        return $this->empty;
    }
}
