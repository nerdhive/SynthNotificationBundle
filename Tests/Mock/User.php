<?php

/**
 * This file is part of the Synth Notification Bundle.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Dom Udall <dom@synthmedia.co.uk>
 */

namespace Synth\NotificationBundle\Tests\Mock;

use Symfony\Component\Security\Core\User\UserInterface;

abstract class User implements UserInterface
{
    public function getEmail()
    {
        return 'user@acmeinc.com';
    }
}