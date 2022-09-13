<?php

namespace App\DTO\Request;

use App\DTO\TranslationItem;
use Symfony\Component\Validator\Constraints as Assert;

class PublishRequest implements RequestDTO
{
    #[Assert\NotBlank]
    public string $defaultLocale;

    /**
     * @var array<int, TranslationItem>|null
     */
    #[Assert\Valid]
    #[Assert\NotBlank]
    public ?array $items = null;
}
