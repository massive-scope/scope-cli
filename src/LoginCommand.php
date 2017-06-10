<?php

namespace Scope\Cli;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class LoginCommand extends Command
{
    protected function configure()
    {
        $this->setName('login');
        $this->addArgument('username', InputArgument::REQUIRED);
        $this->addOption('password', 'p', InputOption::VALUE_REQUIRED);
    }

    protected function interact(InputInterface $input, OutputInterface $output)
    {
        if (!$input->getArgument('username')) {
            $question = new Question('Username:');

            $questionHelper = new QuestionHelper();
            $input->setArgument('username', $questionHelper->ask($input, $output, $question));
        }

        if (!$input->getOption('password')) {
            $question = new Question('Password:');
            $question->setHidden(true);

            $questionHelper = new QuestionHelper();
            $input->setOption('password', $questionHelper->ask($input, $output, $question));
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Hello "' . $input->getArgument('username') . '".');
        $output->writeln('You are authenticated.');
    }
}
