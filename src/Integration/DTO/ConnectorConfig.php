<?php

namespace App\Integration\DTO;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Configuration parameters specific to your connector that are needed to get {@link AuthCredentials}.
 */
class ConnectorConfig
{
    public function __construct(
        #[Assert\NotBlank]
        public readonly ?string $apiKey = null,
    ) {
    }
}
