<?php

namespace App\Integration\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class ConnectorConfig
{
    public function __construct(
        #[Assert\NotBlank()]
        public readonly ?string $apiKey = null,
    ) {
    }
}
