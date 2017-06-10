<?php

namespace Scope\Cli;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class InitializeCommand extends Command
{
    /**
     * @var Configuration
     */
    private $configuration;

    public function __construct(Configuration $configuration)
    {
        parent::__construct();

        $this->configuration = $configuration;
    }

    protected function configure()
    {
        $this->setName('initialize');
        $this->addArgument('host', InputArgument::REQUIRED);
    }

    protected function interact(InputInterface $input, OutputInterface $output)
    {
        if (!$input->getArgument('host')) {
            $question = new Question('Host: ');

            $questionHelper = new QuestionHelper();
            $input->setArgument('host', $questionHelper->ask($input, $output, $question));
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->configuration->set('host', $input->getArgument('host'));
    }
}
