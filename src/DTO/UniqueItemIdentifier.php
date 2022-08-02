<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class UniqueItemIdentifier
{
    #[Assert\NotBlank()]
    #[Assert\Length(min: 1, max: 256)]
    public ?string $uniqueId = null;

    #[Assert\NotBlank()]
    #[Assert\Length(min: 1, max: 256)]
    public ?string $groupId = null;

    /**
     * @var array<string, string>|null
     */
    #[Assert\NotNull()]
    public ?array $metadata = null;
}
