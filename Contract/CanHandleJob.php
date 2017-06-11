<?php

namespace Lneicelis\QueueBundle\Contract;

interface CanHandleJob
{

    public function getJobClass(): string;

    public function handleJob($job);

}