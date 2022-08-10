<?php

namespace App\Integration\Service;

use App\DTO\TranslationItem;
use App\Integration\ApiClient;
use App\Interfaces\Service\PublishServiceInterface;

class PublishService implements PublishServiceInterface
{
    public function __construct(
        private readonly ApiClient $apiClient,
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
