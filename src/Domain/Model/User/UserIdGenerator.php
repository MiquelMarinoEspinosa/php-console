<?php

namespace Php\Console\Domain\Model\User;

interface UserIdGenerator
{
    public function generateId(): string;
}