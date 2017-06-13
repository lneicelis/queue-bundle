<?php

namespace Lneicelis\QueueBundle\Command;

use Illuminate\Console\Command;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Illuminate\Queue\Console\ListFailedCommand as IlluminateListFailedCommand;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ListFailedCommand extends IlluminateListFailedCommand implements ContainerAwareInterface
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
