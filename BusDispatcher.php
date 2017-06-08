<?php

namespace Lneicelis\QueueBundle;

use Illuminate\Bus\Dispatcher;
use Illuminate\Support\Arr;

class BusDispatcher extends Dispatcher
{
    /** @var JobHandlerContract[] */
    protected $jobHandlersByJobClass;

    /**
     * @param JobHandlerContract $jobHandler
     */
    public function addJobHandler(JobHandlerContract $jobHandler)
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
     */
    public function dispatchNow($job, $handler = null)
    {
        $jobClass = get_class($job);
        /** @var JobHandlerContract[] $jobHandlers */
        $jobHandlers = Arr::get($this->jobHandlersByJobClass, $jobClass, []);

        foreach ($jobHandlers as $jobHandler) {
            $jobHandler->handle($job);
        }
        throw new \Exception('LOOOL');
    }
}