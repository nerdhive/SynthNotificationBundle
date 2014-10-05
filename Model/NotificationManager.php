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

abstract class NotificationManager implements NotificationManagerInterface
{

	/**
     * @inheritdoc
     */
    public function createNotification($type, $message)
    {
        $class = $this->getClass();
        /* @var $notification NotificationInterface */
        $notification = new $class;
        $notification->setCreatedAt(new \DateTime("now"));
        $notification->setType($type);
        $notification->setMessage($message);

        return $notification;
    }
}