<?php

namespace Lneicelis\QueueBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="queue_job")
 */
abstract class AbstractJob
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
     * @ORM\Column(name="queue", type="string")
     */
    protected $queue;

    /**
     * @var string|null
     *
     * @ORM\Column(name="queue", type="text")
     */
    protected $payload;

    /**
     * @var int|null
     *
     * @ORM\Column(name="attempts", type="integer")
     */
    protected $attempts;

    /**
     * @var int|null
     *
     * @ORM\Column(name="reserved_at", type="integer", nullable=true)
     */
    protected $reservedAt;

    /**
     * @var int|null
     *
     * @ORM\Column(name="reserved_at", type="integer")
     */
    protected $availableAt;

    /**
     * @var int|null
     *
     * @ORM\Column(name="created_at", type="integer")
     */
    protected $createdAt;

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getQueue()
    {
        return $this->queue;
    }

    /**
     * @param null|string $queue
     * @return $this
     */
    public function setQueue($queue)
    {
        $this->queue = $queue;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * @param null|string $payload
     * @return $this
     */
    public function setPayload($payload)
    {
        $this->payload = $payload;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getAttempts()
    {
        return $this->attempts;
    }

    /**
     * @param int|null $attempts
     * @return $this
     */
    public function setAttempts($attempts)
    {
        $this->attempts = $attempts;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getReservedAt()
    {
        return $this->reservedAt;
    }

    /**
     * @param int|null $reservedAt
     * @return $this
     */
    public function setReservedAt($reservedAt)
    {
        $this->reservedAt = $reservedAt;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getAvailableAt()
    {
        return $this->availableAt;
    }

    /**
     * @param int|null $availableAt
     * @return $this
     */
    public function setAvailableAt($availableAt)
    {
        $this->availableAt = $availableAt;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param int|null $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}