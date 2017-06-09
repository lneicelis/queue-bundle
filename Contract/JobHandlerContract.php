<?php

namespace Lneicelis\QueueBundle\Contract;

interface JobHandlerContract
{
    public function getJobClass(): string;

    public function handle($job);

}