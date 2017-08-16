<?php

namespace Thatside\MoneybirdBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class ThatMoneybirdExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        if (isset($config['redirect_url'])) {
            $container->setParameter('that_moneybird.redirect_url', $config['redirect_url']);
        }
        if (isset($config['client_id'])) {
            $container->setParameter('that_moneybird.client_id', $config['client_id']);
        }
        if (isset($config['client_secret'])) {
            $container->setParameter('that_moneybird.client_secret', $config['client_secret']);
        }
        if (isset($config['debug'])) {
            $container->setParameter('that_moneybird.debug', $config['debug']);
        }
    }

    /**
     * @return string
     */
    public function getAlias()
    {
        return 'that_moneybird';
    }
}
