<?php

namespace App\Integration\Service;

use App\DTO\TranslationItem;
use App\Integration\DTO\AuthCredential;
use App\Interfaces\Service\PublishServiceInterface;

class PublishService implements PublishServiceInterface
{
    /**
     * @param array<int, TranslationItem> $translations
     */
    public function publishContent(AuthCredential $authCredential, array $translations): void
    {
    }
}
