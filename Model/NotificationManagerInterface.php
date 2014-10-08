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

interface NotificationManagerInterface
{
    /**
     * Creates an empty notification instance.
     *
     * @param integer $type notification type as integer
     * @param string $message notification message
     *
     * @return NotificationInterface
     */
    function createNotification($type, $message);

    /**
     * Deletes an existing notification.
     *
     * @param NotificationInterface $notification
     */
    function deleteNotification(NotificationInterface $notification);

    /**
     * Persits a notification.
     *
     * @param NotificationInterface $notification
     */
    function persistNotification(NotificationInterface $notification);

    /**
     * Returns a notification's fully qualified class name.
     *
     * @return string
     */
    function getClass();
}