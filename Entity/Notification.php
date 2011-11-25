<?php

/**
 * This file is part of the Synth Notification Bundle.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Dom Udall <dom@synthmedia.co.uk>
 */

namespace Synth\NotificationBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Synth\NotificationBundle\Model\Notification as BaseNotification;

/**
 * ORM entity for notification.
 *
 * @author Dom Udall <dom@synthmedia.co.uk>
 */
class Notification extends BaseNotification
{
    /**
     * @var UserInterface $owner
     */
    protected $owner;

    /**
     * @var UserInterface $fromUser
     */
    protected $fromUser;

    /**
     * @var integer $type
     */
    protected $type;

    /**
     * Set the owner of the notification (who the notification is to)
     *
     * @param UserInterface $owner
     */
    public function setOwner(UserInterface $owner)
    {
        $this->owner = $owner;
    }

    /**
     * Get the owner of the notification
     *
     * @return User
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Set the sender of the notification (who the notification is from)
     *
     * @param UserInterface $fromUser
     */
    public function setFromUser(UserInterface $fromUser)
    {
        $this->fromUser = $fromUser;
    }

    /**
     * Get the sender of the notification
     *
     * @return User
     */
    public function getFromUser()
    {
        return $this->fromUser;
    }

    /**
     * Set the notification type
     *
     * @param integer $type
     */
    public function setType($type)
    {
        if (!is_int($type)) {
            throw new \Exception(sprintf('Notification type must be set to an integer, %s given.', gettype($type)));
        }
        $this->type = $type;
    }

    /**
     * Get the notification type
     *
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }
}
