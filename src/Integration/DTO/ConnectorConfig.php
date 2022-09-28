<?php

namespace App\Integration\DTO;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * конфигурационные параметры специфичные для вашего конектора которые необходимы для получения AuthCredentials
 */
class ConnectorConfig
{
    public function __construct(
        #[Assert\NotBlank]
        public readonly ?string $apiKey = null,
    ) {
    }
}
