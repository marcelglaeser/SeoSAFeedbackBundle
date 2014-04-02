<?php

namespace SeoSA\FeedbackBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * Class SeoSA\FeedbackBundle\DependencyInjection\SeoSAFeedbackExtension
 */
class SeoSAFeedbackExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $container->setParameter('seo_sa_feedback.message.class', $config['message']['class']);

        if ($config['sonata_admin']['enabled']) {
            $container->setParameter('seo_sa_feedback.sonata_admin.group', $config['sonata_admin']['group']);
            $container->setParameter('seo_sa_feedback.sonata_admin.label', $config['sonata_admin']['label']);
            $loader->load('sonata_admin.yml');
        }


        $container->setParameter('seo_sa_feedback.templating.layout', $config['templating']['layout']);
        $container->setParameter('seo_sa_feedback.templating.message_show', $config['templating']['message_show']);
        $container->setParameter('seo_sa_feedback.templating.message_form', $config['templating']['message_form']);
        $container->setParameter('seo_sa_feedback.templating.message_list', $config['templating']['message_list']);

        if (isset($config['message']['manager']) && $config['message']['manager']) {
            $container->setAlias('seo_sa_feedback.message.manager', $config['message']['manager']);
        } else {
            $container->setAlias('seo_sa_feedback.message.manager', 'seo_sa_feedback.message.manager.default');
        }

    }
}
