<?php

namespace Lneicelis\QueueBundle\Command;

use Illuminate\Console\Command;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Illuminate\Queue\Console\RestartCommand as IlluminateRestartCommand;
use Symfony\Component\DependencyInjection\ContainerInterface;

class RestartCommand extends IlluminateRestartCommand implements ContainerAwareInterface
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
        $this->laravel = $container->get('lneicelis_queue.service.illuminate_container');
    }
}
