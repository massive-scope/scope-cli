<?php

$application = new \Symfony\Component\Console\Application();

$application->add(new \Scope\Cli\LoginCommand());
$application->add(new \Scope\Cli\ProjectsCommand());

$application->run();
