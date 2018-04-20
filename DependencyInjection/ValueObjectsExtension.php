<?php
/**
 * User: Anton Buz (TheHett)
 * Date: 26.03.2018
 * Time: 21:24
 */

declare(strict_types=1);

namespace ValueObjectsBundle\DependencyInjection;

use Symfony\Bundle\FrameworkBundle\DependencyInjection\Configuration;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class ValueObjectsExtension extends Extension
{
    /**
     * @param array $config
     * @param ContainerBuilder $container
     * @throws \Exception
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator([__DIR__ . '/../Resources/config/']));
        $loader->load('services.yml');
    }

    public function getConfiguration(array $config, ContainerBuilder $container)
    {
        return new Configuration(false);
    }

}
