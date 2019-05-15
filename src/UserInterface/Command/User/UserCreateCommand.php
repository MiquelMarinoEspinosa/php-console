<?php

namespace Php\Console\UserInterface\Command\User;

use Php\Console\Application\UseCase\User\CreateUserRequest;
use Php\Console\Application\UseCase\User\CreateUserUseCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UserCreateCommand extends Command
{
    /** @var CreateUserUseCase */
    private $createUserUseCase;

    public function __construct(
        CreateUserUseCase $createUserUseCase,
        string $name = null
    ) {
        parent::__construct($name);
        $this->createUserUseCase = $createUserUseCase;
    }

    protected function configure()
    {
        $this
            ->setName('user:create')
            ->setDescription('Create a new user')
            ->addArgument(
                'name',
                InputArgument::REQUIRED,
                'User\'s name'
            );
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $userName = $input->getArgument('name');
        if (empty($userName)) {
            $output->writeln(
                '<comment>Please, provide the user name.'
                        . ' No user has been created :/</comment>'
            );
            exit();
        }

        try {
            $createUserRequest = new CreateUserRequest($userName);
            $userResource = $this->createUserUseCase->execute($createUserRequest);

            $message = PHP_EOL . '<info>';
            $message .= 'The user has been successfully created. :)' . PHP_EOL;
            $message .= 'id: ' . $userResource->getId() . PHP_EOL;
            $message .= 'name: ' . $userResource->getName() . PHP_EOL;
            $message .= '</info>';

            $output->writeln($message);
        } catch (\Exception $exception) {
            $output->writeln(
                '<error>Oooops! some error happened :/: ' . PHP_EOL
                        . $exception->getMessage() . '</error>'
            );
        }
    }
}
