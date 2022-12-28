<?php

namespace App\Enum;

enum AuthTypeEnum: string
{
    case OAuth = 'OAuth';
    case apiKey = 'apiToken';
}
