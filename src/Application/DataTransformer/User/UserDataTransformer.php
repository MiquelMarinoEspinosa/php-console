<?php

namespace Php\Console\Application\DataTransformer\User;

use Php\Console\Domain\Model\User\User;

class UserDataTransformer
{
    public function transform(User $user): UserResource
    {
        return new UserResource(
            $user->getId(),
            $user->getName()
        );
    }
}