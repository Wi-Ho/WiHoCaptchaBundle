<?php

namespace WiHo\CaptchaBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree.
     *
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('wiho_captcha');

        $rootNode
            ->children()
                ->scalarNode('secret')->isRequired(true)->end()
                ->scalarNode('key')->isRequired(true)->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
