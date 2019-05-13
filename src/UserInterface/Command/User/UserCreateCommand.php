<?php

namespace Php\Console\UserInterface\Command\User;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UserCreateCommand extends Command
{
    /** @var ImportVideosUseCase */
    private $importVideosUseCase;

    public function __construct(
        ImportVideosUseCase $importVideosUseCase,
        string $name = null
    ) {
        parent::__construct($name);
        $this->importVideosUseCase = $importVideosUseCase;
    }

    protected function configure()
    {
        $this
            ->setName('user:create')
            ->setDescription('Create a new user')
            ->addArgument(
                'name',
                InputArgument::IS_ARRAY,
                'User\'s name'
            );
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $sources = $input->getArgument('sources');
        if (empty($sources)) {
            $output->writeln(
                '<comment>Please, provide some sources.'
                        . ' No sources provided. So no videos has been imported :/</comment>'
            );
            exit();
        }

        try {
            $importVideosRequest = new ImportVideosRequest($sources);
            $videoCollectionResource = $this->importVideosUseCase->execute($importVideosRequest);
            $message = $this->buildMessageResponse($videoCollectionResource);
            $output->writeln($message);
        } catch (\Exception $exception) {
            $output->writeln(
                '<error>Oooops! some error happened :/: ' . PHP_EOL
                        . $exception->getMessage() . '</error>'
            );
        }
    }

    private function buildMessageResponse($videoCollectionResource): string
    {
        $message = '<info>';
        $source = '';
        foreach ($videoCollectionResource->videoResources() as $videoResource) {
            if ($videoResource->sourceName() !== $source) {
                if (!empty($source)) {
                    $message .= PHP_EOL;
                }
                $source = $videoResource->sourceName();
                $message .= "imported source: $source" . PHP_EOL;
            }
            $message .= 'imported video: "'
                . $videoResource->title() . '"; Url: '
                . $videoResource->url();

            if (!empty($videoResource->tags())) {
                $message .= '; Tags: '
                    . implode(',', $videoResource->tags());
            }

            $message .= PHP_EOL;
        }
        $message .= '</info>';

        return $message;
    }
}
