<?php

namespace App\Interfaces\Service;

use App\DTO\Request\PublishRequest;
use App\Exception\AccessDeniedException;
use App\Integration\DTO\AuthCredentials;

interface PublishServiceInterface
{
    /**
     * @throws AccessDeniedException
     */
    public function publishContent(AuthCredentials $credentials, PublishRequest $publishRequest): void;
}
