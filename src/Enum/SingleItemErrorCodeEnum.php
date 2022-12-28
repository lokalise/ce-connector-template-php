<?php

namespace App\Enum;

enum SingleItemErrorCodeEnum: string
{
    case ITEM_NOT_FOUND_ERROR = 'ITEM_NOT_FOUND_ERROR';
    case INTERNAL_ERROR = 'INTERNAL_ERROR';
    case CLIENT_ERROR = 'CLIENT_ERROR';
}
