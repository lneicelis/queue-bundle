# QueueBundle
Thin wrapper of 
[laravel queue package](https://laravel.com/docs/5.4/queues)
for Symfony 3 applications
## Features
* Seamless integration
* Driver agnostic API
* Command Line Interface for queues management
* Multiple drivers (sync, database, beanstalkd, sqs, redis, null)
* Multiple queues
* Job scheduling
* Job prioritization
* Job lifecycle events
* Failed jobs tracking, retrying

## Table of Contents
* [Installation](#installation)
* [Configuration](#configuration)
* [Usage]()


### Installation

#### Step 1. Require the bundle with composer:

    composer require lneicelis/queue-bundle

#### Step 2. Enable the bundle in the kernel:

Once you install the bundle you will need to make change in your `AppKernel.php` by adding the bundle class entry like this.

    // app/AppKernel.php
    ...
    $bundles = [
        ...
        new Lneicelis\QueueBundle\LneicelisQueueBundle(), // ADD THIS
        ...
    ];

### Configuration

##### Step 1. Import default bundle configuration

    // app/config.yml
    imports:
        ...
        - { resource: "@LneicelisQueueBundle/Resources/config/config.yml" }
        ...

##### Step 2. Configure failed jobs tracking
To enable failed jobs tracking you need to create database table 
where all the failed jobs will be persisted.
It can be done by simply extending `Lneicelis\QueueBundle\Entity\AbstractFailedJob` entity:

    <?php
    
    namespace AppBundle\Entity;
    
    use Lneicelis\QueueBundle\Entity\AbstractFailedJob;
    
    class FailedJob extends AbstractFailedJob
    {
    
    }

After creating FailedJob entity update database schema by running

    php bin/console doctrine:schema:update --force

or

    php bin/console doctrine:migrations:diff
    php bin/console doctrine:migrations:migrate

##### Step 3. Configure queue for test environment (optional)

In your test environment you may want to run your background jobs 
in synchronous fashion. In order to do so you need to set your
queue driver to sync:


    // app/config/config_test.yml
    ...
    lneicelis_queue:
        queue:
            default: sync
            
##### Step 4. Configuring driver of your choice
* [Database](#database-driver-configuration)
* [Beanstalkd](#beanstalkd-driver-configuration)
* [Amazon sqs](#amazon-sqs-driver-configuration)
* [Redis](#redis-driver-configuration)

##### Database driver configuration

    // app/config/config.yml
    ...
    lneicelis_queue:
        queue:
            default: database
        database:
            default: mysql
            connections:
                mysql:
                    driver: mysql
                    host: '%database_host%'
                    port: '%database_port%'
                    database: '%database_name%'
                    username: '%database_user%'
                    password: '%database_password%'
                    unix_socket:
                    charset: utf8mb4
                    collation: utf8mb4_unicode_ci
                    prefix:
                    strict: true
                    engine: null

##### Beanstalkd driver configuration

    // app/config/config.yml
    ...
    lneicelis_queue:
        queue:
            default: beanstalkd
            connections:
                beanstalkd:
                    driver: beanstalkd
                    host: localhost
                    queue: default
                    retry_after: 90

##### Amazon sqs driver configuration

    // app/config/config.yml
    ...
    lneicelis_queue:
        queue:
            default: sqs
            connections:
                sqs:
                    driver: sqs
                    key: your-public-key
                    secret: your-secret-key
                    prefix: https://sqs.us-east-1.amazonaws.com/your-account-id
                    queue: your-queue-name
                    region: us-east-1
                    
##### Redis driver configuration

    // app/config/config.yml
    ...
    lneicelis_queue:
        queue:
            default: redis
            connections:
                redis:
                    driver: redis
                    connection: default
                    queue: default
                    retry_after: 90
        database:
            redis:
                client: predis
                default:
                    host: 127.0.0.1
                    password: null
                    port: 6379
                    database: 0
                    
### Usage

* [Creating a job](#creating-a-job)    
* [Pushing jobs to a queue](#pushing-job-to-a-queue)
* [Processing jobs](#processing-a-job)

### Creating a job
Queue job should be plain PHP object that can be serialized/unserialized;

    // src/AppBundle/Job/SendWelcomeEmailJob.php
    
    class SendWelcomeEmailJob
    {
        protected $email;
        
        public function __construct(string $email)
        {
            $this->email = $email;
        }
        
        public function getEmail(): string
        {
            return $this->email;
        }
    }

### Pushing job to a queue

Via directly accessed queue from the container:

    // src/AppBundle/Controller/RegistrationController.php
    
    ...
    public function registedAction(Request $request)
    {
        ...
        $queue = $this->get('lneicelis_queue.service.queue');
        
        $queue->push(new SendWelcomeEmailJob($email));
        ...
    }

Via injected queue instance:

    /** @var \Lneicelis\QueueBundle\Contract\QueueContract */
    protected $queue;

    public function scheduleWelcomeEmail(UserRegisteredEvent $event)
    {
        $email = $event->getUser()->getEmail();
    
        $this->queue->push(new SendWelcomeEmailJob($email));
    }
    
### Processing a job
First of all you need to create a class which can handle a job.
The getJobClass method must return a job class name which that job handler
can handle.

    // src/AppBundle/JobHandler/WelcomeEmailJobHandler.php
        
        class WelcomeEmailJobHandler implements CanHandleJob
        {
            public function getJobClass(): string
            {
                return SendWelcomeEmailJob::class;
            }
        
            /**
             * @param SendWelcomeEmailJob $job
             */
            public function handleJob($job)
            {
                // Email sending logic
            }
        }

Ok looks like we are all set. The last step is to run a worker.

    php bin/console queue:work database queue=default --tries=3 --timeout=90
    
That is it! your job should be processed by now.

Learn more at [official laravel queue documentation](https://laravel.com/docs/5.4/queues)