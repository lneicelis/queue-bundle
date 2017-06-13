<?php

namespace Lneicelis\QueueBundle\Factory;

use Illuminate\Bus\BusServiceProvider;
use Illuminate\Cache\CacheServiceProvider;
use Illuminate\Config\Repository;
use Illuminate\Container\Container;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\Connectors\ConnectionFactory;
use Illuminate\Database\DatabaseManager;
use Illuminate\Events\EventServiceProvider;
use Illuminate\Queue\QueueServiceProvider;
use Lneicelis\QueueBundle\Application;
use Lneicelis\QueueBundle\BusDispatcher;
use Illuminate\Contracts\Bus\Dispatcher as DispatcherContract;
use Illuminate\Contracts\Queue\Factory as QueueFactoryContract;
use Illuminate\Contracts\Bus\QueueingDispatcher as QueueingDispatcherContract;
use Symfony\Component\DependencyInjection\ContainerInterface;


class IlluminateContainerFactory
{
    /** @var ContainerInterface */
    protected $container;

    /** @var \Illuminate\Contracts\Container\Container */
    protected $illuminateContainer;

    protected $providerClasses = [
        CacheServiceProvider::class,
        QueueServiceProvider::class,
        EventServiceProvider::class,
    ];

    /**
     * IlluminateContainerFactory constructor.
     * @param array $config
     * @param ContainerInterface $container
     */
    public function __construct(array $config, ContainerInterface $container)
    {
        $this->container = $container;
        $this->illuminateContainer = $this->createContainer($config, $container);
    }

    public function getContainer()
    {
        return $this->illuminateContainer;
    }

    /**
     * @param array $config
     * @param ContainerInterface $container
     * @return Application
     */
    protected function createContainer(array $config, ContainerInterface $container)
    {
        $exceptionHandler = $container->get('lneicelis_queue.service.exception_handler');
        $app = new Application($config, $container);

        foreach ($this->providerClasses as $providerClass) {
            $provider = new $providerClass($app);

            $provider->register();
        }

        $app->singleton('config', function () use ($config) {
            return new Repository($config);
        });

        $app->alias('events', \Illuminate\Contracts\Events\Dispatcher::class);

        $this->registerDatabase($app);
        $this->registerBus($app);


        $app->bind(ExceptionHandler::class, function (Container $app) use ($exceptionHandler) {
            return $exceptionHandler;
        });

        Application::setInstance($app);

        return $app;
    }

    /**
     * @param Container $container
     */
    protected function registerDatabase(Container $container)
    {
        $container->singleton('db.factory', function (Container $app) {
            return new ConnectionFactory($app);
        });

        $container->singleton('db', function (Container $app) {
            return new DatabaseManager($app, $app['db.factory']);
        });

        $container->bind('db.connection', function (Container $app) {
            return $app['db']->connection();
        });
    }

    /**
     * @param Container $container
     */
    protected function registerBus(Container $container)
    {
        $container->singleton(BusDispatcher::class, function ($app) {
            return new BusDispatcher($app, function ($connection = null) use ($app) {
                return $app[QueueFactoryContract::class]->connection($connection);
            });
        });

        $container->alias(
            BusDispatcher::class, DispatcherContract::class
        );

        $container->alias(
            BusDispatcher::class, QueueingDispatcherContract::class
        );
    }
}