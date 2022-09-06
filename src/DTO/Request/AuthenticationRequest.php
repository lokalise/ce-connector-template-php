<?php

namespace App\DTO\Request;

use App\Enum\AuthTypeEnum;
use App\Validator\NotBlank;

class AuthenticationRequest implements RequestDTO
{
    #[NotBlank(groups: [AuthTypeEnum::apiKey])]
    public ?string $key = null;

    #[NotBlank(groups: [AuthTypeEnum::OAuth])]
    public ?string $redirectUrl = null;
}
