<?php

namespace App\DTO\Request;

use App\DTO\ContentItem;
use Symfony\Component\Validator\Constraints as Assert;

class PublishRequest implements RequestDTO
{
    /**
     * @var array<int, ContentItem>|null
     */
    #[Assert\Valid()]
    #[Assert\NotBlank()]
    public ?array $items = null;
}
