<?php

namespace Php\Console\Application\UseCase\User;

use Php\Console\Application\DataTransformer\User\UserDataTransformer;
use Php\Console\Application\DataTransformer\User\UserResource;
use Php\Console\Domain\Model\User\UserNotFound;
use Php\Console\Domain\Model\User\UserRepository;

class GetUserUseCase
{
    /** @var UserRepository */
    private $userRepository;
    /** @var UserDataTransformer */
    private $userDataTransformer;

    public function __construct(
        UserRepository $userRepository,
        UserDataTransformer $userDataTransformer
    ) {
        $this->userRepository = $userRepository;
        $this->userDataTransformer = $userDataTransformer;
    }

    public function execute(GetUserRequest $getUserRequest): UserResource
    {
        try {
            $user = $this->userRepository->find($getUserRequest->getId());

            return $this->userDataTransformer->transform($user);
        } catch (UserNotFound $userNotFound) {
            throw new CannotGetUser();
        }
    }
}