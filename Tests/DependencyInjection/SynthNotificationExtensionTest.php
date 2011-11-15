<?php

/**
* This file is part of the Synth Notification Bundle.
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*
* @author Dom Udall <dom@synthmedia.co.uk>
*/

namespace Synth\NotificationBundle\Tests\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Yaml\Parser;
use Synth\NotificationBundle\DependencyInjection\SynthNotificationExtension;

class SynthNotificationExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ContainerBuilder
     */
    protected $configuration;

    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testLoadThrowsExceptionUnlessDatabaseDriverSet()
    {
        $loader = new SynthNotificationExtension();
        $config = $this->getEmptyConfig();
        unset($config['db_driver']);
        $loader->load(array($config), new ContainerBuilder());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testLoadThrowsExceptionUnlessDatabaseDriverIsValid()
    {
        $loader = new SynthNotificationExtension();
        $config = $this->getEmptyConfig();
        $config['db_driver'] = 'foo';
        $loader->load(array($config), new ContainerBuilder());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testLoadThrowsExceptionMongoDBDriverIsInvalid()
    {
        $loader = new SynthNotificationExtension();
        $config = $this->getEmptyConfig();
        $config['db_driver'] = 'mongodb';
        $loader->load(array($config), new ContainerBuilder());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testLoadThrowsExceptionCouchDBDriverIsInvalid()
    {
        $loader = new SynthNotificationExtension();
        $config = $this->getEmptyConfig();
        $config['db_driver'] = 'couchdb';
        $loader->load(array($config), new ContainerBuilder());
    }

    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testLoadThrowsExceptionUnlessUserModelClassSet()
    {
        $loader = new SynthNotificationExtension();
        $config = $this->getEmptyConfig();
        unset($config['user_class']);
        $loader->load(array($config), new ContainerBuilder());
    }

    public function testLoadManagerClassWithDefaults()
    {
        $this->createEmptyConfiguration();

        $this->assertHasDefinition('synth_notification.notification_manager');
    }

    public function testLoadManagerClass()
    {
        $this->createFullConfiguration();

        $this->assertHasDefinition('synth_notification.notification_manager');
    }

    public function testLoadConfigurationWithDefaults()
    {
        $this->createEmptyConfiguration();

        $this->assertParameter(
            'Synth\NotificationBundle\Entity\Notification',
            'synth_notification.notification.class'
        );
        $this->assertParameter(
            'Synth\NotificationBundle\Entity\NotificationManager',
            'synth_notification.notification_manager.class'
        );
        $this->assertParameter(
            true,
            'synth_notification.email_notification'
        );
        $this->assertParameter(
            array('webmaster@example.com' => 'webmaster'),
            'synth_notification.new_notification.from_email'
        );
    }

    public function testLoadConfiguration()
    {
        $this->createFullConfiguration();

        $this->assertParameter(
            'Acme\MyBundle\Entity\Notification',
            'synth_notification.notification.class'
        );
        $this->assertParameter(
            'Acme\MyBundle\Entity\NotificationManager',
            'synth_notification.notification_manager.class'
        );
        $this->assertParameter(
            false,
            'synth_notification.email_notification'
        );
        $this->assertParameter(
            array('newnotification@yoursite.co.uk' => 'Site Notification Admin'),
            'synth_notification.new_notification.from_email'
        );
    }

    /**
     * @return array
     */
    protected function getEmptyConfig()
    {
        $yaml = <<<EOF
db_driver: orm
user_class: Acme\MyBundle\Entity\User
EOF;
        $parser = new Parser();

        return $parser->parse($yaml);
    }

    /**
     * @return array
     */
    protected function getFullConfig()
    {
        $yaml = <<<EOF
db_driver: orm
user_class: Acme\MyBundle\Entity\User
notification_class: Acme\MyBundle\Entity\Notification
notification_manager_class: Acme\MyBundle\Entity\NotificationManager
email_notification: false
from_email:
    address: admin@yoursite.co.uk
    sender_name: Site Admin
new_notification:
    from_email:
        address: newnotification@yoursite.co.uk
        sender_name: Site Notification Admin
EOF;
        $parser = new Parser();

        return $parser->parse($yaml);
    }

    /**
     * @return ContainerBuilder
     */
    protected function createEmptyConfiguration()
    {
        $this->configuration = new ContainerBuilder();
        $loader = new SynthNotificationExtension();
        $config = $this->getEmptyConfig();
        $loader->load(array($config), $this->configuration);
        $this->assertTrue($this->configuration instanceof ContainerBuilder);
    }

    /**
     * @return ContainerBuilder
     */
    protected function createFullConfiguration()
    {
        $this->configuration = new ContainerBuilder();
        $loader = new SynthNotificationExtension();
        $config = $this->getFullConfig();
        $loader->load(array($config), $this->configuration);
        $this->assertTrue($this->configuration instanceof ContainerBuilder);
    }

    private function assertParameter($value, $key)
    {
        $this->assertEquals($value, $this->configuration->getParameter($key), sprintf('%s parameter is correct', $key));
    }

    private function assertHasDefinition($id)
    {
        $this->assertTrue(($this->configuration->hasDefinition($id) ?: $this->configuration->hasAlias($id)));
    }

    protected function tearDown()
    {
        unset($this->configuration);
    }
}
