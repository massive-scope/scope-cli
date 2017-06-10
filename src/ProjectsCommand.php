<?php

namespace Scope\Cli;

use Scope\Cli\GraphQL\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ProjectsCommand extends Command
{
    /**
     * @var Client
     */
    private $client;

    public function __construct(Client $client)
    {
        parent::__construct();

        $this->client = $client;
    }

    protected function configure()
    {
        $this->setName('projects');
        $this->addOption('page', null, InputOption::VALUE_OPTIONAL, '', 1);
        $this->addOption('page-size', null, InputOption::VALUE_OPTIONAL, '', 10);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $page = $input->getOption('page');
        $pageSize = $input->getOption('page-size');

        $data = $this->client->query(
            sprintf(
                '{projects(offset:%s,size:%s){total,items{id,title}}}',
                ($page - 1) * $pageSize,
                $pageSize
            ),
            'projects'
        );

        $output->writeln('Projects');
        $output->writeln('Total: ' . $data['total']);

        $table = new Table($output);
        $table->setHeaders(['id', 'title']);
        $table->setRows($data['items']);
        $table->render();
    }
}
