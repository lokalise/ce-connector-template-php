<?php

namespace App\DTO\Request;

use App\Enum\AuthTypeEnum;
use App\Integration\DTO\ConnectorConfig;
use Symfony\Component\Validator\Constraints as Assert;

class RefreshRequest implements RequestDTO
{
    #[Assert\NotBlank()]
    public ?string $refreshToken = null;
}
