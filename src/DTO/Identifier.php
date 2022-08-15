<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class Identifier
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

    public static function createFromIdentifier(Identifier $identifier): static
    {
        $cacheItem = new static();
        $cacheItem->uniqueId = $identifier->uniqueId;
        $cacheItem->groupId = $identifier->groupId;
        $cacheItem->metadata = $identifier->metadata;

        return $cacheItem;
    }
}
