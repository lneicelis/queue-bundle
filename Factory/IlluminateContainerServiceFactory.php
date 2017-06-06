<?php

namespace Lneicelis\QueueBundle\Factory;

use Illuminate\Contracts\Container\Container;

class IlluminateContainerServiceFactory
{
    /**
     * @var Container
     */
    protected $illuminateContainer;

    /**
     * @param Container $illuminateContainer
     */
    public function __construct(Container $illuminateContainer)
    {
        $this->illuminateContainer = $illuminateContainer;
    }

    /**
     * @param string $serviceName
     * @return mixed
     */
    public function getService(string $serviceName)
    {
        return $this->illuminateContainer->make($serviceName);
    }
}