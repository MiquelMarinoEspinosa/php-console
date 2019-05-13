<?php

namespace Php\Console\Infrastructure\Domain\Model\User;

use Php\Console\Domain\Model\User\UserIdGenerator;
use Ramsey\Uuid\Uuid;

class UuidUserIdGenerator implements UserIdGenerator
{
    public function generateId(): string
    {
        return Uuid::uuid4();
    }
}