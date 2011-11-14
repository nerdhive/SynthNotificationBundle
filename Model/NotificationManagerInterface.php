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
     * @return NotificationInterface
     */
    function createNotification();

    /**
     * Deletes an existing notification.
     *
     * @param NotificationInterface $notification
     */
    function deleteNotification(NotificationInterface $notification);

    /**
     * Updates a notification.
     *
     * @param NotificationInterface $notification
     */
    function updateNotification(NotificationInterface $notification);

    /**
     * Returns a notification's fully qualified class name.
     *
     * @return string
     */
    function getClass();
}