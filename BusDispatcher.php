<?php

namespace Lneicelis\QueueBundle;

use Illuminate\Bus\Dispatcher;
use Illuminate\Support\Arr;
use Lneicelis\QueueBundle\Contract\CanHandleJob;
use Lneicelis\QueueBundle\Exception\NoJobHandlersRegisteredException;

class BusDispatcher extends Dispatcher
{
    /** @var CanHandleJob[] */
    protected $jobHandlersByJobClass = [];

    /**
     * @param CanHandleJob $jobHandler
     */
    public function addJobHandler(CanHandleJob $jobHandler)
    {
        $jobClass = $jobHandler->getJobClass();

        $handlers = Arr::get($this->jobHandlersByJobClass, $jobClass, []);
        $handlers[] = $jobHandler;

        $this->jobHandlersByJobClass[$jobClass] = $handlers;
    }

    /**
     * @param mixed $job
     * @param null $handler
     * @return void
     * @throws NoJobHandlersRegisteredException
     */
    public function dispatchNow($job, $handler = null)
    {
        $jobClass = get_class($job);
        /** @var CanHandleJob[] $jobHandlers */
        $jobHandlers = Arr::get($this->jobHandlersByJobClass, $jobClass, []);

        if (empty($jobHandlers)) {
            throw new NoJobHandlersRegisteredException(
                sprintf('Job class: "%"', $jobClass)
            );
        }

        foreach ($jobHandlers as $jobHandler) {
            $jobHandler->handle($job);
        }
    }
}