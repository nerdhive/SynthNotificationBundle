<?php

/**
 * This file is part of the Synth Notification Bundle.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Dom Udall <dom@synthmedia.co.uk>
 */

namespace Synth\NotificationBundle\Mailer;

use Symfony\Component\Security\Core\User\UserInterface;

interface MailerInterface
{
    /**
     * Send an email notification to a user, informing them of a new notification
     *
     * @param UserInterface $user
     */
    function sendNotificationEmailMessage(UserInterface $user);
}
