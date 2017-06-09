<?php

namespace Lneicelis\QueueBundle;

use Lneicelis\QueueBundle\DependencyInjection\JobHandlerCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class LneicelisQueueBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new JobHandlerCompilerPass());
    }
}