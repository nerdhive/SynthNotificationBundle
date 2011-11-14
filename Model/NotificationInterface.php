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

use Symfony\Component\Security\Core\User\UserInterface;

interface NotificationInterface
{
    function getId();

    function setMessage($message);

    function getMessage();

    function setRead($read);

    function isRead();

    function setCreatedAt(\DateTime $createdAt);

    function getCreatedAt();

    function setOwner(UserInterface $owner);

    function getOwner();

    function setFromUser(UserInterface $fromUser);

    function getFromUser();

    function setType($type);

    function getType();
}
