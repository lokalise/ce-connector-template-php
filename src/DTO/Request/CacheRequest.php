<?php

namespace App\DTO\Request;

use App\DTO\UniqueItemIdentifier;
use Symfony\Component\Validator\Constraints as Assert;

class CacheRequest implements RequestDTO
{
    /**
     * @var array<int, UniqueItemIdentifier>|null
     */
    #[Assert\Valid()]
    #[Assert\NotBlank()]
    public ?array $items = null;
}
