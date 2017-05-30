<?php

use Illuminate\Database\Connectors\ConnectionFactory;
use Illuminate\Database\DatabaseManager;
use Illuminate\Container\Container;

require 'vendor/autoload.php';

class Job {}

$config = require_once 'config.php';

$container = new Container();

$container->singleton('config', function () use ($config) {
    return new \Illuminate\Config\Repository($config);
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

/** @var DatabaseManager $dbManager */
$dbManager = $container['db'];

$dbManager->availableDrivers();


$queue = new \Illuminate\Queue\Capsule\Manager($container);

$defaultConnectionName = $config['queue']['default'];

$defaultConnectionConfig = $config['queue']['connections'][$defaultConnectionName];

$queue->addConnection($defaultConnectionConfig);

$queue->setAsGlobal();

$queue->push(new Job());



