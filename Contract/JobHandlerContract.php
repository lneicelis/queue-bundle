<?php

namespace Lneicelis\QueueBundle;

interface JobHandlerContract
{
    public function getJobClass(): string;

    public function handle($job);

}