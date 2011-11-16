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

class SystemMailer
{
    public $values = array();

    public function send(\Swift_Message $message)
    {
        $values = array();

        $values['subject'] = $message->getSubject();
        $values['from'] = $message->getFrom();
        $values['to'] = $message->getTo();
        $values['body'] = $message->getBody();

        $this->values = $values;

        return $values;
    }
}