<?php

namespace App\Service;

use App\Enum\AuthTypeEnum;
use Symfony\Bundle\FrameworkBundle\Routing\Attribute\AsRoutingConditionService;

/**
 * The service is used in route conditions to match routes depending on the type of authorization.
 */
#[AsRoutingConditionService]
class AuthTypeService
{
    public function __construct(
        private readonly AuthTypeEnum $defaultAuthType,
    ) {
    }

    public function isApiKey(): bool
    {
        return AuthTypeEnum::apiKey === $this->defaultAuthType;
    }

    public function isOAuth(): bool
    {
        return AuthTypeEnum::OAuth === $this->defaultAuthType;
    }
}
