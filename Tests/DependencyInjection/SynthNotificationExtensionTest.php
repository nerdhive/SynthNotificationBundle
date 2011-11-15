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
    protected $configuration;

    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testUserLoadThrowsExceptionUnlessDatabaseDriverSet()
    {
        $loader = new SynthNotificationExtension();
        $config = $this->getEmptyConfig();
        unset($config['db_driver']);
        $loader->load(array($config), new ContainerBuilder());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testUserLoadThrowsExceptionUnlessDatabaseDriverIsValid()
    {
        $loader = new SynthNotificationExtension();
        $config = $this->getEmptyConfig();
        $config['db_driver'] = 'foo';
        $loader->load(array($config), new ContainerBuilder());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testUserLoadThrowsExceptionMongoDBDriverIsInvalid()
    {
        $loader = new SynthNotificationExtension();
        $config = $this->getEmptyConfig();
        $config['db_driver'] = 'mongodb';
        $loader->load(array($config), new ContainerBuilder());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testUserLoadThrowsExceptionCouchDBDriverIsInvalid()
    {
        $loader = new SynthNotificationExtension();
        $config = $this->getEmptyConfig();
        $config['db_driver'] = 'couchdb';
        $loader->load(array($config), new ContainerBuilder());
    }

    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testUserLoadThrowsExceptionUnlessUserModelClassSet()
    {
        $loader = new SynthNotificationExtension();
        $config = $this->getEmptyConfig();
        unset($config['user_class']);
        $loader->load(array($config), new ContainerBuilder());
    }

    /**
     * getEmptyConfig
     *
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

    protected function tearDown()
    {
        unset($this->configuration);
    }
}
