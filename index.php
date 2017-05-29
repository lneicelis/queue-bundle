<?php

use Illuminate\Database\Connectors\ConnectionFactory;
use Illuminate\Database\DatabaseManager;
use Illuminate\Container\Container;

require 'vendor/autoload.php';

class Job {}

$container = new Container();

$container->singleton('config', function () {
    $databaseConfig = require_once 'config.php';

    return new \Illuminate\Config\Repository([
        'database' => $databaseConfig,
    ]);
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

$queue->addConnection([
    'driver' => 'database',
    'table' => 'jobs',
    'queue' => 'default',
    'retry_after' => 90,
]);

$queue->setAsGlobal();

$queue->push(new Job());



