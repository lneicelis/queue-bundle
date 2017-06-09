<?php

namespace Lneicelis\QueueBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class JobHandlerCompilerPass implements CompilerPassInterface
{
    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $serviceId = 'lneicelis_queue.service.bus_dispatcher';

        // always first check if the primary service is defined
        if (!$container->has($serviceId)) {
            return;
        }

        $definition = $container->findDefinition($serviceId);

        // find all service IDs with the app.mail_transport tag
        $taggedServices = $container->findTaggedServiceIds('queue.job_handler');

        foreach ($taggedServices as $id => $tags) {
            // add the transport service to the ChainTransport service
            $definition->addMethodCall('addJobHandler', [new Reference($id)]);
        }
    }
}