<?php

namespace App\Enum;

enum PerLocaleErrorCodeEnum: string
{
    case INTERNAL_ERROR = 'INTERNAL_ERROR';
    case CLIENT_ERROR = 'CLIENT_ERROR';
}
