<?php

namespace SeoSA\FeedbackBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class SeoSA\FeedbackBundle\DependencyInjection\Configuration
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode    = $treeBuilder->root('seo_sa_feedback');

        $rootNode->children()
            ->arrayNode('message')
                ->isRequired()
                ->children()
                    ->scalarNode('class')->isRequired()->end()
                    ->scalarNode('manager')->defaultNull()->end()
                ->end()
            ->end();

        $rootNode->children()
            ->arrayNode('templating')
                ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('layout')->defaultValue('SeoSAFeedbackBundle::layout.html.twig')->end()
                    ->scalarNode('message_show')->defaultValue('SeoSAFeedbackBundle:Message:show.html.twig')->end()
                    ->scalarNode('message_form')->defaultValue('SeoSAFeedbackBundle:Message:form.html.twig')->end()
                    ->scalarNode('message_list')->defaultValue('SeoSAFeedbackBundle:Message:list.html.twig')->end()
                ->end()
            ->end();

        $rootNode->children()
            ->arrayNode('sonata_admin')
                ->addDefaultsIfNotSet()
                ->children()
                    ->booleanNode('enabled')->defaultFalse()->end()
                    ->scalarNode('group')->defaultValue('Feedback')->end()
                    ->scalarNode('label')->defaultValue('Messages')->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
