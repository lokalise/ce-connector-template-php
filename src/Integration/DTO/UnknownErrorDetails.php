<?php

namespace App\Integration\DTO;

use App\DTO\ErrorDetails;

class UnknownErrorDetails implements ErrorDetails
{
    public function toArray(): array
    {
        return [];
    }
}
