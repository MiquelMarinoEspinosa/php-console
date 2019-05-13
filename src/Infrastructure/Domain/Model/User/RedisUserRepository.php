<?php

namespace Php\Console\Infrastructure\Domain\Model\User;

use Php\Console\Domain\Model\User\User;
use Php\Console\Domain\Model\User\UserNotFound;
use Php\Console\Domain\Model\User\UserRepository;
use Redis;

class RedisUserRepository implements UserRepository
{
    /** @var Redis */
    private $redis;

    const PREFIX = 'user_';

    public function __construct(Redis $redis)
    {
        $this->redis = $redis;
    }

    public function find(string $id): User
    {
        $userAsArray = json_decode(
            $this->redis->get(self::PREFIX . $id),
            true
        );

        if (null === $userAsArray) {
            throw new UserNotFound();
        }

        return new User(
            $userAsArray['id'],
            $userAsArray['name']
        );
    }

    public function persist(User $user)
    {
        $redisKey = self::PREFIX . $user->getId();
        $userAsArray = [
            'id' => $user->getId(),
            'name' => $user->getName()
        ];

        $this->redis->set($redisKey, json_encode($userAsArray));
    }
}