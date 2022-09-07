<?php

namespace App\DTO\Request;

use App\DTO\Identifier;
use Symfony\Component\Validator\Constraints as Assert;

class TranslateRequest implements RequestDTO
{
    #[Assert\NotBlank]
    public string $defaultLocale;

    /**
     * @var array<int, string>|null
     */
    #[Assert\All(
        new Assert\Type('string'),
    )]
    #[Assert\NotBlank()]
    public ?array $locales = null;

    /**
     * @var array<int, Identifier>|null
     */
    #[Assert\Valid()]
    #[Assert\NotBlank()]
    public ?array $items = null;
}
