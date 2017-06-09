<?php

namespace Lneicelis\QueueBundle\Command;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Illuminate\Queue\Console\WorkCommand as IlluminateWorkCommand;
use Symfony\Component\DependencyInjection\ContainerInterface;

class WorkCommand extends IlluminateWorkCommand implements ContainerAwareInterface
{
    use ContainerAwareCommandTrait;

    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;

        $this->worker = $container->get('lneicelis_queue.service.queue_worker');
        $this->laravel = $container->get('lneicelis_queue.service.illuminate_container');
    }
}
