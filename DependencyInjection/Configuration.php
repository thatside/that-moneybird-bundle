<?php

/*
 * This file is part of the KamiMoneyBirdApiBundle package.
 *
 * (c) Stepanenko Stanislav <dsazztazz@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Thatside\MoneybirdBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('that_moneybird');
        $rootNode
            ->children()
                ->scalarNode('redirect_url')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('client_id')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('client_secret')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->booleanNode('debug')
                    ->defaultFalse()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
