<?php

namespace Lneicelis\QueueBundle;

use Illuminate\Console\Command;
use Lneicelis\QueueBundle\DependencyInjection\JobHandlerCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\Console\Application;
use Symfony\Component\Finder\Finder;

class LneicelisQueueBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new JobHandlerCompilerPass());
    }

    public function boot()
    {
        // By default factory created services are lazy
        // That means JobHandlers are not added to the bus dispatcher
        // Until actual service is not requested from the service
        $this->container->get('lneicelis_queue.service.bus_dispatcher');
    }

    /**
     * {@inheritdoc}
     */
    public function registerCommands(Application $application)
    {
        if (!is_dir($dir = $this->getPath().'/Command')) {
            return;
        }

        if (!class_exists('Symfony\Component\Finder\Finder')) {
            throw new \RuntimeException('You need the symfony/finder component to register bundle commands.');
        }

        $finder = new Finder();
        $finder->files()->name('*Command.php')->in($dir);

        $prefix = $this->getNamespace().'\\Command';
        foreach ($finder as $file) {
            $ns = $prefix;
            if ($relativePath = $file->getRelativePath()) {
                $ns .= '\\'.str_replace('/', '\\', $relativePath);
            }
            $class = $ns.'\\'.$file->getBasename('.php');
            if ($this->container) {
                $commandIds = $this->container->hasParameter('console.command.ids') ? $this->container->getParameter('console.command.ids') : array();
                $alias = 'console.command.'.strtolower(str_replace('\\', '_', $class));
                if (isset($commandIds[$alias]) || $this->container->has($alias)) {
                    continue;
                }
            }

            $r = new \ReflectionClass($class);

            if ($r->isSubclassOf(Command::class) && !$r->isAbstract()) {
                /** @var Command $instance */
                $instance = $r->newInstanceWithoutConstructor();
                $instance->init($instance->getName());

                $application->add($instance);
            }
        }
    }
}