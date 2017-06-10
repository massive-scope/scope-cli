<?php

$configuration = new \Scope\Cli\Configuration();
$client = new \Scope\Cli\GraphQL\Client($configuration);

$application = new \Symfony\Component\Console\Application();

$application->add(new \Scope\Cli\LoginCommand());
$application->add(new \Scope\Cli\ProjectsCommand($client));
$application->add(new \Scope\Cli\InitializeCommand($configuration));

$application->run();
