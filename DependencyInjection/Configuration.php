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

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Configuration class for Synth Notification Bundle.
 *
 * @author Dom Udall <dom@synthmedia.co.uk>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * (non-PHPdoc)
     *
     * @see Symfony\Component\Config\Definition.ConfigurationInterface::getConfigTreeBuilder()
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('synth_notification');

        $rootNode
            ->children()
                ->scalarNode('db_driver')
                    ->cannotBeOverwritten()
                    ->isRequired()
                    ->cannotBeEmpty()
                    ->end()
                ->scalarNode('user_class')
                    ->isRequired()
                    ->cannotBeEmpty()
                    ->end()
                ->scalarNode('notification_class')
                    ->defaultValue('Synth\NotificationBundle\Entity\Notification')
                    ->cannotBeEmpty()
                    ->end()
                ->scalarNode('notification_manager_class')
                    ->defaultValue('Synth\NotificationBundle\Entity\NotificationManager')
                    ->cannotBeEmpty()
                    ->end()
                ->scalarNode('mailer_class')
                    ->defaultValue('Synth\NotificationBundle\Mailer\Mailer')
                    ->cannotBeEmpty()
                    ->end()
                ->booleanNode('email_notification')
                    ->defaultTrue()
                    ->end()
                ->arrayNode('from_email')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('address')
                            ->defaultValue('webmaster@example.com')
                            ->cannotBeEmpty()
                            ->end()
                        ->scalarNode('sender_name')
                            ->defaultValue('webmaster')
                            ->cannotBeEmpty()
                            ->end()
                        ->end()
                    ->end()
                ->arrayNode('new_notification')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('from_email')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('address')
                                    ->end()
                                ->scalarNode('sender_name')
                                    ->end()
                                ->end()
                            ->end()
                        ->scalarNode('template')
                            ->defaultValue('SynthNotificationBundle:NewNotification:mail.txt.twig')
                            ->cannotBeEmpty()
                            ->end()
                        ->end()
                    ->end()
            ->end();

        $this->addServiceSection($rootNode);

        return $treeBuilder;
    }

    /**
     * Creates the services section of the configuration file.
     *
     * @param ArrayNodeDefinition $node Root node of configuration tree builder
     */
    private function addServiceSection(ArrayNodeDefinition $node)
    {
        $node
            ->addDefaultsIfNotSet()
            ->children()
                ->arrayNode('service')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('mailer')
                            ->defaultValue('synth_notification.mailer.default')
                            ->end()
                        ->scalarNode('notification_manager')
                            ->defaultValue('synth_notification.notification_manager.default')
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
}
