<?php

namespace Lneicelis\QueueBundle\Command;

use LogicException;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\DependencyInjection\ContainerInterface;

trait ContainerAwareCommandTrait
{
    /**
     * @var ContainerInterface|null
     */
    private $container;

    /**
     * @return ContainerInterface
     *
     * @throws \LogicException
     */
    protected function getContainer()
    {
        if (null === $this->container) {
            $application = $this->getApplication();
            if (null === $application) {
                throw new \LogicException('The container cannot be retrieved as the application instance is not yet set.');
            }

            $this->container = $application->getKernel()->getContainer();
        }

        return $this->container;
    }

    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;

        // By default factory created services are lazy
        // That means JobHandlers are not added to the bus dispatcher
        // Until actual service is not requested from the service
        $container->get('lneicelis_queue.service.bus_dispatcher');

        $this->setUp($container);
    }
}