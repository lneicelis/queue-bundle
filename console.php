<?php

namespace Lneicelis\QueueBundle;

use Lneicelis\QueueBundle\Factory\IlluminateContainerFactory;

require 'vendor/autoload.php';

class Job {

    protected $test = 123333;

    function handle(Job $job)
    {
        var_dump('job executed', $job);
    }
}


$containerFactory = new IlluminateContainerFactory(new CustomExceptionHandler());
$container = $containerFactory->getContainer();

$events = $container['events'];
$events->listen('*', function ($event) {
    var_dump($event);
});

$worker = $container['queue.worker'];

$console = new \Symfony\Component\Console\Application('queue', '0.1.0');

$workCommand = new \Lneicelis\QueueBundle\Command\WorkCommand($worker);
$workCommand->setLaravel($container);

$console->add($workCommand);
$console->run();



