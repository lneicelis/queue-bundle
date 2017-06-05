<?php

return [
    'queue' => [
        /*
        |--------------------------------------------------------------------------
        | Default Queue Driver
        |--------------------------------------------------------------------------
        |
        | Laravel's queue API supports an assortment of back-ends via a single
        | API, giving you convenient access to each back-end using the same
        | syntax for each one. Here you may set the default queue driver.
        |
        | Supported: "sync", "database", "beanstalkd", "sqs", "redis", "null"
        |
        */
        'default' => 'database',

        /*
        |--------------------------------------------------------------------------
        | Queue Connections
        |--------------------------------------------------------------------------
        |
        | Here you may configure the connection information for each server that
        | is used by your application. A default configuration has been added
        | for each back-end shipped with Laravel. You are free to add more.
        |
        */
        'connections' => [
            'sync' => [
                'driver' => 'database',
                'table' => 'queue_jobs',
                'queue' => 'default',
                'retry_after' => 90,
            ],
            'database' => [
                'driver' => 'database',
                'table' => 'queue_jobs',
                'queue' => 'default',
                'retry_after' => 90,
            ],
            'beanstalkd' => [
                'driver' => 'beanstalkd',
                'host' => 'localhost',
                'queue' => 'default',
                'retry_after' => 90,
            ],
            'sqs' => [
                'driver' => 'sqs',
                'key' => 'your-public-key',
                'secret' => 'your-secret-key',
                'prefix' => 'https://sqs.us-east-1.amazonaws.com/your-account-id',
                'queue' => 'your-queue-name',
                'region' => 'us-east-1',
            ],
            'redis' => [
                'driver' => 'redis',
                'connection' => 'default',
                'queue' => 'default',
                'retry_after' => 90,
            ],
        ],

        /*
        |--------------------------------------------------------------------------
        | Failed Queue Jobs
        |--------------------------------------------------------------------------
        |
        | These options configure the behavior of failed queue job logging so you
        | can control which database and table are used to store the jobs that
        | have failed. You may change them to any database / table you wish.
        |
        */
        'failed' => [
            'database' => 'mysql',
            'table'    => 'queue_failed_jobs',
        ],
    ],

    'database' => [
        /*
        |--------------------------------------------------------------------------
        | Default Database Connection Name
        |--------------------------------------------------------------------------
        |
        | Here you may specify which of the database connections below you wish
        | to use as your default connection for all database work. Of course
        | you may use many connections at once using the Database library.
        |
        */
        'default' => 'mysql',

        /*
        |--------------------------------------------------------------------------
        | Database Connections
        |--------------------------------------------------------------------------
        |
        | Here are each of the database connections setup for your application.
        | Of course, examples of configuring each database platform that is
        | supported by Laravel is shown below to make development simple.
        |
        |
        | All database work in Laravel is done through the PHP PDO facilities
        | so make sure you have the driver for your particular database of
        | choice installed on your machine before you begin development.
        |
        */
        'connections' => [
            'mysql' => [
                'driver' => 'mysql',
                'host' => '127.0.0.1',
                'port' => '3306',
                'database' => 'account_market',
                'username' => 'account_market',
                'password' => 'account_market',
                'unix_socket' => '',
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'prefix' => '',
                'strict' => true,
                'engine' => null,
            ],

        ],
    ]
];