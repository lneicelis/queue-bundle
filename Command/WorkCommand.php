<?php

namespace Lneicelis\QueueBundle\Command;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;

class WorkCommand extends \Illuminate\Queue\Console\WorkCommand implements ContainerAwareInterface
{
    use ContainerAwareCommandTrait;
}