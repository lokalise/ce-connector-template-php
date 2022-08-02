<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class LocaleItem
{
    #[Assert\NotBlank()]
    #[Assert\Length(min: 1, max: 256)]
    public string $name;

    #[Assert\NotBlank()]
    #[Assert\Length(min: 2, max: 5)]
    public string $code;
}
