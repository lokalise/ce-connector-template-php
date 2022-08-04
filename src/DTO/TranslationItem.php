<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class TranslationItem extends Identifier
{
    /**
     * @var array<string, string>|null
     */
    #[Assert\NotNull()]
    public ?array $translations = null;
}
