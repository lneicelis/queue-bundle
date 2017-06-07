<?php

namespace Lneicelis\QueueBundle\Factory;

use Illuminate\Bus\BusServiceProvider;
use Illuminate\Cache\CacheServiceProvider;
use Illuminate\Config\Repository;
use Illuminate\Container\Container;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Database\Connectors\ConnectionFactory;
use Illuminate\Database\DatabaseManager;
use Illuminate\Events\EventServiceProvider;
use Illuminate\Queue\QueueServiceProvider;
use Lneicelis\QueueBundle\Application;

class IlluminateContainerFactory
{
    /** @var \Illuminate\Contracts\Container\Container */
    protected $container;

    protected $providerClasses = [
        CacheServiceProvider::class,
        QueueServiceProvider::class,
        EventServiceProvider::class,
        BusServiceProvider::class,
    ];

    public function __construct(array $config, ExceptionHandler $exceptionHandler)
    {
        $this->container = $this->createContainer($config, $exceptionHandler);
    }

    public function getContainer()
    {
        return $this->container;
    }

    protected function createContainer(array $config, ExceptionHandler $exceptionHandler)
    {
        $container = new Application();

        $container->singleton('config', function () use ($config) {
            return new Repository($config);
        });

        $container->singleton('db.factory', function (Container $app) {
            return new ConnectionFactory($app);
        });

        $container->singleton('db', function (Container $app) {
            return new DatabaseManager($app, $app['db.factory']);
        });

        $container->bind('db.connection', function (Container $app) {
            return $app['db']->connection();
        });

        $container->bind(ExceptionHandler::class, function (Container $app) use ($exceptionHandler) {
            return $exceptionHandler;
        });

        foreach ($this->providerClasses as $providerClass) {
            $provider = new $providerClass($container);

            $provider->register();
        }

        return $container;
    }
}