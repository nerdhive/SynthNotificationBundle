<?php

/**
 * This file is part of the Synth Notification Bundle.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Dom Udall <dom@synthmedia.co.uk>
 */

namespace Synth\NotificationBundle\Test\Model;

use Synth\NotificationBundle\Model\Notification;

class NotificationTest extends \PHPUnit_Framework_TestCase
{
    public function testMessage()
    {
        $notification = $this->getNotification();
        $this->assertNull($notification->getMessage());

        $notification->setMessage('Hello test world');
        $this->assertEquals('Hello test world', $notification->getMessage());
    }

    protected function getNotification()
    {
        return $this->getMockForAbstractClass('Synth\NotificationBundle\Model\Notification');
    }
}
