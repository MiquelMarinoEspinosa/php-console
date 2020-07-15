<?php

namespace Php\Console\Tests\Unit\Application\UseCase;

use Php\Console\Application\DataTransformer\User\UserDataTransformer;
use Php\Console\Application\DataTransformer\User\UserResource;
use Php\Console\Application\UseCase\User\GetUserRequest;
use Php\Console\Application\UseCase\User\GetUserUseCase;
use Php\Console\Domain\Model\User\User;
use Php\Console\Domain\Model\User\UserRepository;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

class GetUserUseCaseTest extends TestCase
{
    use ProphecyTrait;
    public function testUserFound()
    {
        $id ='rewsd-ewqer-dsdas-qewqe';
        $name = 'miquel';
        $user = new User($id, $name);
        $userResource = new UserResource($id, $name);
        $userRepository = $this->prophesize(UserRepository::class);
        $userRepository->find($id)->shouldBeCalled()->willReturn($user);
        $userDataTransformer = $this->prophesize(UserDataTransformer::class);
        $userDataTransformer->transform($user)->shouldBeCalled()->willReturn($userResource);
        $useCase = new GetUserUseCase(
            $userRepository->reveal(),
            $userDataTransformer->reveal()
        );
        $request = new GetUserRequest($id);
        $this->assertEquals(
            $userResource,
            $useCase->execute($request)
        );
    }
}
