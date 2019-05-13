<?php

namespace Php\Console\Application\UseCase\User;

class CreateUserRequest
{
    /** @var string */
    private $name;

    public function __construct(
        string $name
    ) {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }
}