<?php

namespace Lneicelis\QueueBundle\Command;

use Illuminate\Console\Command;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Illuminate\Queue\Console\WorkCommand as IlluminateWorkCommand;
use Symfony\Component\DependencyInjection\ContainerInterface;

class WorkCommand extends IlluminateWorkCommand implements ContainerAwareInterface
{
    use ContainerAwareCommandTrait;

    public function init()
    {
        Command::__construct();
    }

    /**
     * {@inheritdoc}
     */
    public function setUp(ContainerInterface $container = null)
    {
        $this->worker = $container->get('lneicelis_queue.service.queue_worker');
        $this->laravel = $container->get('lneicelis_queue.service.illuminate_container');
    }
}
