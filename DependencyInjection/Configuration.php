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
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
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
                    ->defaultValue('webmaster@example.com')
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
            ->end();

        return $treeBuilder;
    }
}
