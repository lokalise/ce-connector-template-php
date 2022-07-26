<?php

namespace App\DTO\Request;

use App\DTO\UniqueItemIdentifier;
use Symfony\Component\Validator\Constraints as Assert;

class TranslateRequest implements RequestDTO
{
    /**
     * @var array<int, string>
     */
    #[Assert\All(
        new Assert\Type('string'),
    )]
    public array $locales = [];

    /**
     * @var array<int, UniqueItemIdentifier>
     */
    #[Assert\Valid()]
    public array $items = [];
}
