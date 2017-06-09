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


class IlluminateContainerFactory
{
    /** @var \Illuminate\Contracts\Container\Container */
    protected $container;

    protected $providerClasses = [
        CacheServiceProvider::class,
        QueueServiceProvider::class,
        EventServiceProvider::class,
//        BusServiceProvider::class,
    ];

    public function __construct(ExceptionHandler $exceptionHandler)
    {
        $config = require_once __DIR__.'/../config.php';

        $this->container = $this->createContainer($config, $exceptionHandler);
    }

    public function getContainer()
    {
        return $this->container;
    }

    protected function createContainer(array $config, ExceptionHandler $exceptionHandler)
    {
        $container = new Application();

        foreach ($this->providerClasses as $providerClass) {
            $provider = new $providerClass($container);

            $provider->register();
        }

        $container->singleton('config', function () use ($config) {
            return new Repository($config);
        });

        $this->registerDatabase($container);
        $this->registerBus($container);

        $container->bind(ExceptionHandler::class, function (Container $app) use ($exceptionHandler) {
            return $exceptionHandler;
        });

        return $container;
    }

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