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

$containerFactory = new IlluminateContainerFactory(new CustomExceptionHandler());
$container = $containerFactory->getContainer();

$queue  = $container['queue'];

$queue->push(new Job());


