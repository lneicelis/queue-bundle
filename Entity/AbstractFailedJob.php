<?php

namespace Lneicelis\QueueBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="queue_failed_job")
 */
abstract class AbstractFailedJob
{
    /**
     * @var int|null
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     */
    protected $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="connection", type="string")
     */
    protected $connection;

    /**
     * @var string|null
     *
     * @ORM\Column(name="queue", type="string")
     */
    protected $queue;

    /**
     * @var string|null
     *
     * @ORM\Column(name="payload", type="text")
     */
    protected $payload;

    /**
     * @var string|null
     *
     * @ORM\Column(name="exception", type="text")
     */
    protected $exception;

    /**
     * @var int|null
     *
     * @ORM\Column(name="failed_at", type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     */
    protected $failedAt;
}