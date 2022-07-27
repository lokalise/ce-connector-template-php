<?php

namespace App\DTO\Request;

use App\DTO\UniqueItemIdentifier;
use Symfony\Component\Validator\Constraints as Assert;

class CacheRequest implements RequestDTO
{
    /**
     * @var array<int, UniqueItemIdentifier>
     */
    #[Assert\Valid()]
    public array $items = [];
}