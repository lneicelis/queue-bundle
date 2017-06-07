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

$queue  = $container['queue'];

$queue->push(new Job());


