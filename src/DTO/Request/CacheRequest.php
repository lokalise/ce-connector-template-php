<?php

namespace App\DTO\Request;

use App\DTO\Identifier;
use Symfony\Component\Validator\Constraints as Assert;

class CacheRequest implements RequestDTO
{
    /**
     * @var array<int, Identifier>|null
     */
    #[Assert\Valid]
    #[Assert\NotBlank]
    public ?array $items = null;
}
