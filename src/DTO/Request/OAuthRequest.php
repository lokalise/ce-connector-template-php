<?php

namespace App\DTO\Request;

use App\Enum\OAuthResponseParamsEnum;
use App\Integration\DTO\OAuthParams;
use App\Validator\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;

class OAuthRequest implements RequestDTO
{
    #[Assert\Valid()]
    #[NotBlank(groups: [OAuthResponseParamsEnum::query])]
    public ?OAuthParams $query = null;

    #[Assert\Valid()]
    #[NotBlank(groups: [OAuthResponseParamsEnum::body])]
    public ?OAuthParams $body = null;

    #[Assert\NotBlank()]
    public ?string $redirectUrl = null;
}
