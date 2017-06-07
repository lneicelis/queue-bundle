<?php

namespace Lneicelis\QueueBundle;

use Lneicelis\QueueBundle\Factory\IlluminateContainerFactory;

require 'vendor/autoload.php';

class Job {

    function handle(Job $job)
    {
        var_dump('job executed', $job);
    }
}


$config = require_once 'config.php';

$containerFactory = new IlluminateContainerFactory($config, new CustomExceptionHandler());
$container = $containerFactory->getContainer();

$worker = $container['queue.worker'];

$console = new \Symfony\Component\Console\Application('queue', '0.1.0');

$workCommand = new \Lneicelis\QueueBundle\Command\WorkCommand($worker);
$workCommand->setLaravel($container);

$console->add($workCommand);
$console->run();



