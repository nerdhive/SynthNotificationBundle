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
    
    public function testRead()
    {
        $notification = $this->getNotification();
        $this->assertFalse($notification->isRead());

        $notification->setRead(true);
        $this->assertTrue($notification->isRead());

        try {
            $notification->setRead('not a boolean');
        } catch (\Exception $e) {
            return;
        }

        $this->fail('An expected exception has not been raised.');
    }

    protected function getNotification()
    {
        return $this->getMockForAbstractClass('Synth\NotificationBundle\Model\Notification');
    }
}
