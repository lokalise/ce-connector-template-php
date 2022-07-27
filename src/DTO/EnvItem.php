<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class EnvItem
{
    #[Assert\NotBlank()]
    #[Assert\Length(min: 2, max: 5)]
    public ?string $defaultLocale = null;

    /**
     * @var array<int, LocaleItem>|null
     */
    #[Assert\NotNull()]
    public ?array $locales = null;

    /**
     * @var array<string, string>|null
     */
    #[Assert\NotNull()]
    public ?array $cacheItemStructure = null;
}
