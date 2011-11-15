<?php

/**
 * This file is part of the Synth Notification Bundle.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Dom Udall <dom@synthmedia.co.uk>
 */

namespace Synth\NotificationBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class SynthNotificationExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $processor = new Processor();
        $configuration = new Configuration();
        $config = $processor->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        if (in_array(strtolower($config['db_driver']), array('mongodb', 'couchdb'))) {
            throw new \InvalidArgumentException(
                sprintf('Currently only the orm db driver is supported, %s support is en route.', $config['db_driver'])
            );
        } elseif (!in_array(strtolower($config['db_driver']), array('orm'))) {
            throw new \InvalidArgumentException(sprintf('Invalid db driver "%s".', $config['db_driver']));
        }

        $loader->load(sprintf('%s.yml', $config['db_driver']));

        $container->setParameter('synth_notification.notification.class', $config['notification_class']);
        $container->setParameter('synth_notification.notification_manager.class', $config['notification_manager_class']);

        $container->setParameter('synth_notification.email_notification', $config['email_notification']);

        $container->setParameter('synth_notification.from_email.address', $config['from_email']['address']);
        $container->setParameter('synth_notification.from_email.sender_name', $config['from_email']['sender_name']);
    }
}
