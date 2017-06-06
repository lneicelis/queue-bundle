<?php

namespace Lneicelis\QueueBundle\Service;

use Illuminate\Bus\BusServiceProvider;
use Illuminate\Config\Repository;
use Illuminate\Container\Container;
use Illuminate\Database\Connectors\ConnectionFactory;
use Illuminate\Database\DatabaseManager;
use Illuminate\Events\EventServiceProvider;
use Illuminate\Queue\QueueServiceProvider;

class IlluminateContainer
{
    /** @var \Illuminate\Contracts\Container\Container */
    protected $container;

    protected $providerClasses = [
        QueueServiceProvider::class,
        EventServiceProvider::class,
        BusServiceProvider::class,
    ];

    public function __construct()
    {
        $config = require_once '../config.php';

        $this->container = $this->createConrainer($config);
    }

    protected function createConrainer(array $config)
    {
        $container = new Container();

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

        foreach ($this->providerClasses as $providerClass) {
            $provider = new $providerClass($container);

            $provider->register();
        }

        return $container;
    }
}