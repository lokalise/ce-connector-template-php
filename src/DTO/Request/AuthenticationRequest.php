<?php

namespace App\DTO\Request;

use Symfony\Component\Validator\Constraints as Assert;

class AuthenticationRequest implements RequestDTO
{
    #[Assert\NotBlank]
    public ?string $redirectUrl = null;
}
