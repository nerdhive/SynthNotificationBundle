<?php

/**
 * This file is part of the Synth Notification Bundle.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Dom Udall <dom@synthmedia.co.uk>
 */

namespace Synth\NotificationBundle\Tests\Entity;

use Synth\NotificationBundle\Entity\Notification;
use Synth\NotificationBundle\Mock\User;

class NotificationTest extends \PHPUnit_Framework_TestCase
{
    public function testOwner()
    {
        $notification = $this->getNotification();
        $this->assertNull($notification->getOwner());

        $user = $this->getUser();

        $notification->setOwner($user);
        $this->assertEquals($user, $notification->getOwner());

        try {
            $notification->setOwner('not an instance of UserInterface');
        } catch (\Exception $e) {
            return;
        }

        $this->fail('An expected exception has not been raised.');
    }

    public function testFromUser()
    {
        $notification = $this->getNotification();
        $this->assertNull($notification->getFromUser());

        $user = $this->getUser();

        $notification->setFromUser($user);
        $this->assertEquals($user, $notification->getFromUser());

        try {
            $notification->setFromUser('not an instance of UserInterface');
        } catch (\Exception $e) {
            return;
        }

        $this->fail('An expected exception has not been raised.');
    }

    public function testType()
    {
        $notification = $this->getNotification();
        $this->assertNull($notification->getType());

        $notification->setType(1);
        $this->assertEquals(1, $notification->getType());

        try {
            $notification->setType('not a number');
        } catch (\Exception $e) {
            return;
        }

        $this->fail('An expected exception has not been raised.');
    }

    protected function getNotification()
    {
        return new Notification();
    }

    protected function getUser()
    {
        return $this->getMockForAbstractClass('Synth\NotificationBundle\Tests\Mock\User');
    }
}