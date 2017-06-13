<?php
/**
 * Created by PhpStorm.
 * User: lneicelis
 * Date: 2017.06.07
 * Time: 12:43
 */

namespace Lneicelis\QueueBundle;

use Illuminate\Container\Container;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Application extends Container implements \Illuminate\Contracts\Foundation\Application
{
    /** @var array */
    protected $config;

    /** @var ContainerInterface */
    protected $container;

    /**
     * @param array $config
     * @param ContainerInterface $container
     */
    public function __construct(array $config, ContainerInterface $container)
    {
        $this->config = $config;
        $this->container = $container;
    }

    /**
     * Get the version number of the application.
     *
     * @return string
     */
    public function version()
    {
        // TODO: Implement version() method.
    }

    /**
     * Get the base path of the Laravel installation.
     *
     * @return string
     */
    public function basePath()
    {
        return realpath($this->container->getParameter('kernel.root_dir') . '/../');
    }

    /**
     * Get or check the current application environment.
     *
     * @return string
     */
    public function environment()
    {
        // TODO: Implement environment() method.
    }

    /**
     * Determine if the application is currently down for maintenance.
     *
     * @return bool
     */
    public function isDownForMaintenance()
    {
        return false;
    }

    /**
     * Register all of the configured providers.
     *
     * @return void
     */
    public function registerConfiguredProviders()
    {
        // TODO: Implement registerConfiguredProviders() method.
    }

    /**
     * Register a service provider with the application.
     *
     * @param  \Illuminate\Support\ServiceProvider|string $provider
     * @param  array $options
     * @param  bool $force
     * @return \Illuminate\Support\ServiceProvider
     */
    public function register($provider, $options = [], $force = false)
    {
        // TODO: Implement register() method.
    }

    /**
     * Register a deferred provider and service.
     *
     * @param  string $provider
     * @param  string $service
     * @return void
     */
    public function registerDeferredProvider($provider, $service = null)
    {
        // TODO: Implement registerDeferredProvider() method.
    }

    /**
     * Boot the application's service providers.
     *
     * @return void
     */
    public function boot()
    {
        // TODO: Implement boot() method.
    }

    /**
     * Register a new boot listener.
     *
     * @param  mixed $callback
     * @return void
     */
    public function booting($callback)
    {
        // TODO: Implement booting() method.
    }

    /**
     * Register a new "booted" listener.
     *
     * @param  mixed $callback
     * @return void
     */
    public function booted($callback)
    {
        // TODO: Implement booted() method.
    }

    /**
     * Get the path to the cached services.php file.
     *
     * @return string
     */
    public function getCachedServicesPath()
    {
        // TODO: Implement getCachedServicesPath() method.
    }

    protected function getPath($path = '')
    {
        return realpath($this->basePath() . $path);
    }

    protected function setPaths()
    {
        $this->instance('path.base', $this->basePath());
        $this->instance('path.public', $this->getPath('/web'));
        $this->instance('path.storage', $this->getPath('/var/queue'));
    }
}