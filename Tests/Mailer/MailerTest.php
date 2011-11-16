<?php

/**
 * This file is part of the Synth Notification Bundle.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Dom Udall <dom@synthmedia.co.uk>
 */

namespace Synth\NotificationBundle\Tests\Mailer;

use Synth\NotificationBundle\Mailer\Mailer;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Routing\RouterInterface;
use Synth\NotificationBundle\Tests\Mock\SystemMailer;

class MailerTest extends \PHPUnit_Framework_TestCase
{

    public function testSendNotificationEmailMessage()
    {
        $systemMailer = $this->getSystemMailer();

        $router = $this->getRouter();
        $templating = $this->getTemplateEngine();
        $parameters = array(
            'new_notification.template' => 'SynthNotificationBundle:NewNotification:mail.txt.twig',
            'from_email' => array(
                'address' => 'webmaster@example.com'
            )
        );

        $mailer = new Mailer($systemMailer, $router, $templating, $parameters);

        $user = $this->getUser();

        $mailer->sendNotificationEmailMessage($user);

        $values = array(
            'body' => 'This is the content',
            'subject' => 'This is the subject',
            'from' => array(
                'webmaster@example.com' => null
            ),
            'to' => array(
                'user@acmeinc.com' => null
            )
        );
        $this->assertEquals($values, $systemMailer->values);
    }

    protected function getSystemMailer()
    {
        $systemMailer = new SystemMailer();

        // Make sure the System Mailer is still OK!
        $values = array();
        $this->assertEquals($values, $systemMailer->values);

        return $systemMailer;
    }

    protected function getRouter()
    {
        return $this->getMock('\\Symfony\\Component\\Routing\\RouterInterface');
    }

    protected function getTemplateEngine()
    {
        $templateEngine = $this->getMock('\\Symfony\\Bundle\\FrameworkBundle\\Templating\\EngineInterface');

        $messageTemplate = <<<MAIL
This is the subject
This is the content
MAIL;

        $templateEngine
            ->expects($this->once())
            ->method('render')
            ->will($this->returnValue($messageTemplate));

        return $templateEngine;
    }

    protected function getUser()
    {
        return $this->getMockForAbstractClass('Synth\NotificationBundle\Tests\Mock\User');
    }
}