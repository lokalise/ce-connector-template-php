<?php

namespace App\Service;

use App\Enum\AuthTypeEnum;
use Symfony\Bundle\FrameworkBundle\Routing\Attribute\AsRoutingConditionService;

#[AsRoutingConditionService]
class AuthTypeService
{
    public function __construct(
        private readonly AuthTypeEnum $defaultAuthType,
    ) {
    }

    public function isApiKey(): bool
    {
        return $this->defaultAuthType === AuthTypeEnum::apiKey;
    }

    public function isOAuth(): bool
    {
        return $this->defaultAuthType === AuthTypeEnum::OAuth;
    }
}