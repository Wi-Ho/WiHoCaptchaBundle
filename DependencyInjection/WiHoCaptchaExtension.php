<?php

namespace WiHo\CaptchaBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Config\FileLocator;

class WiHoCaptchaExtension extends Extension
{
    private $alias;

    /**
     * @param string $alias
     */
    public function __construct($alias)
    {
        $this->alias = $alias;
    }

    /**
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter($this->getAlias().'.secret', $config["secret"]);
        $container->setParameter($this->getAlias().'.key', $config["key"]);

        $resources = $container->getParameter('twig.form.resources');
        $container->setParameter('twig.form.resources', array_merge(array('WiHoCaptchaBundle:Form:wiho_captcha.html.twig'), $resources));
    }
}
