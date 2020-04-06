<?php declare(strict_types=1);

namespace Refugis\ODM\ElasticaBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeParentInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder(): NodeParentInterface
    {
        if (\method_exists(TreeBuilder::class, 'getRootNode')) {
            $treeBuilder = new TreeBuilder('elastica_odm');
            $rootNode = $treeBuilder->getRootNode();
        } else {
            $treeBuilder = new TreeBuilder();
            $rootNode = $treeBuilder->root('elastica_odm');
        }

        $this->addConnectionSection($rootNode);
        $this->addOdmSection($rootNode);

        return $treeBuilder;
    }

    private function addConnectionSection(ArrayNodeDefinition $rootNode): void
    {
        $rootNode
            ->children()
                ->arrayNode('connection')
                ->addDefaultsIfNotSet()
                ->isRequired()
                    ->children()
                        ->scalarNode('url')->isRequired()->end()
                        ->integerNode('connect_timeout')->defaultValue(30)->end()
                        ->integerNode('timeout')->defaultNull()->end()
                    ->end()
                ->end()
            ->end()
        ;
    }

    private function addOdmSection(ArrayNodeDefinition $rootNode): void
    {
        $rootNode
            ->children()
                ->arrayNode('odm')
                    ->children()
                        ->scalarNode('index_suffix')->defaultNull()->end()
                        ->arrayNode('mappings')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('prefix_dir')->defaultValue('%kernel.project_dir%/Document')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
