<?php

/**
 * This file is part of the Synth Notification Bundle.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Dom Udall <dom@synthmedia.co.uk>
 */

namespace Synth\NotificationBundle\Model;

abstract class Notification implements NotificationInterface
{
    /**
     * @var integer $id
     */
    protected $id;

    /**
     * @var string $message
     */
    protected $message;

    /**
     * @var boolean $isRead
     */
    protected $isRead = false;

    /**
     * @var \DateTime $createdAt
     */
    protected $createdAt;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the notification message
     *
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * Get the notification message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set if the notification has been read by the owner
     *
     * @throws \Exception if $read isn't a boolean value
     *
     * @param boolean $read
     */
    public function setRead($read)
    {
        if (!is_bool($read)) {
            throw new \Exception(sprintf('Notification read state must be set to a boolean, %s given.', gettype($read)));
        }
        $this->isRead = $read;
    }

    /**
     * Returns if the notification has been read by the owner
     *
     * @return boolean
     */
    public function isRead()
    {
        return $this->isRead;
    }

    /**
     * Set the date when the notification was created
     *
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Get the date when the notification was created
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
