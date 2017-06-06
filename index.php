<?php

use Illuminate\Bus\BusServiceProvider;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Database\Connectors\ConnectionFactory;
use Illuminate\Database\DatabaseManager;
use Illuminate\Container\Container;
use Illuminate\Events\EventServiceProvider;
use Illuminate\Queue\QueueServiceProvider;

require 'vendor/autoload.php';

class Job {

    function handle(Job $job)
    {
        var_dump('job received');
    }
}

class CustomExceptionHandler implements ExceptionHandler {

    /**
     * Report or log an exception.
     *
     * @param  \Exception $e
     * @return void
     */
    public function report(Exception $e)
    {
        var_dump($e->getMessage());
        // TODO: Implement report() method.
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $e
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Exception $e)
    {
        var_dump($e->getMessage());
        // TODO: Implement render() method.
    }

    /**
     * Render an exception to the console.
     *
     * @param  \Symfony\Component\Console\Output\OutputInterface $output
     * @param  \Exception $e
     * @return void
     */
    public function renderForConsole($output, Exception $e)
    {
        var_dump($e->getMessage());
        // TODO: Implement renderForConsole() method.
    }
}

$providerClasses = [
    QueueServiceProvider::class,
    EventServiceProvider::class,
    BusServiceProvider::class,
];

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

$container->bind(ExceptionHandler::class, CustomExceptionHandler::class);

foreach ($providerClasses as $providerClass) {
    $provider = new $providerClass($container);

    $provider->register();
}

$queue  = $container['queue'];
$worker = $container['queue.worker'];

//$queue->push(new Job());

$worker->runNextJob('database', 'default', new \Illuminate\Queue\WorkerOptions());


