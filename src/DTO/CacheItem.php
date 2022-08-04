<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class CacheItem extends Identifier
{
    /**
     * @var array<string, string>|null
     */
    #[Assert\NotNull()]
    public ?array $fields = null;
}
