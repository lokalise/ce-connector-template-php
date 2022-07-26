<?php

namespace App\DTO\Request;

use Symfony\Component\Validator\Constraints as Assert;

class RefreshRequest implements RequestDTO
{
    #[Assert\NotBlank]
    public string $refreshKey;
}