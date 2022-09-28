<?php

namespace App\Integration\DTO;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * параметры которые 3-я сторона отправлят на редирект урл при oauth авторизации
 */
class OAuthParams
{
    public function __construct(
        #[Assert\NotBlank]
        public readonly ?string $code = null,
    ) {
    }
}
