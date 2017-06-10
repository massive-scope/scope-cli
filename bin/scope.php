<?php

$application = new \Symfony\Component\Console\Application();

$application->add(new \Scope\Cli\LoginCommand());

$application->run();
