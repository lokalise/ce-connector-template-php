<?php

namespace App\Integration\Service;

use App\DTO\TranslationItem;
use App\Interfaces\ApiClientInterface;
use App\Interfaces\Service\PublishServiceInterface;

class PublishService implements PublishServiceInterface
{
    public function __construct(
        private readonly ApiClientInterface $apiClient,
    ) {
    }

    /**
     * @param array<int, TranslationItem> $translations
     */
    public function publishContent(string $accessToken, array $translations): void
    {
        $this->apiClient->publish($accessToken, $translations);
    }
}
