<?php

namespace App\Integration\Service;

use App\DTO\Request\PublishRequest;
use App\Integration\DTO\AuthCredentials;
use App\Interfaces\Service\PublishServiceInterface;

class PublishService implements PublishServiceInterface
{
    public function publishContent(AuthCredentials $credentials, PublishRequest $publishRequest): void
    {
    }
}
