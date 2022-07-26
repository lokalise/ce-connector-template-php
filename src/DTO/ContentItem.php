<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class ContentItem extends UniqueItemIdentifier
{
    /**
     * @var array<string, string>|null
     */
    #[Assert\NotNull()]
    public ?array $translations = null;
}
