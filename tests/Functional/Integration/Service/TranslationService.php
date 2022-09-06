<?php

namespace App\Tests\Functional\Integration\Service;

use App\DTO\Request\TranslateRequest;
use App\DTO\TranslationItem;
use App\DTO\Identifier;
use App\Integration\DTO\AuthCredentials;
use App\Interfaces\Service\TranslationServiceInterface;

class TranslationService implements TranslationServiceInterface
{
    /**
     * @param array<int, string> $locales
     * @param array<int, Identifier> $identifiers
     *
     * @return array<int, TranslationItem>
     */
    public function getTranslations(AuthCredentials $authCredential, TranslateRequest $translateRequest): array
    {
        $locales = $translateRequest->locales;

        return array_map(
            static function (Identifier $translation) use ($locales) {
                $translationItem = TranslationItem::createFromIdentifier($translation);
                $translationItem->translations = array_combine($locales, $locales);

                return $translationItem;
            },
            $translateRequest->items
        );
    }
}
