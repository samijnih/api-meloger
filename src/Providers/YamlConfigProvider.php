<?php

namespace Providers;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader as DIYamlFileLoader;
use Symfony\Component\Routing\Loader\YamlFileLoader as RoutingYamlFileLoader;

/**
 * The YAML config provider.
 */
class YamlConfigProvider implements ServiceProviderInterface
{
    /**
     * @var FileLocator
     */
    private static $locator;


    /**
     * Constructor.
     *
     * @param  array $configPaths
     *
     * @return void
     */
    public function __construct(array $configPaths)
    {
        self::$locator = new FileLocator($configPaths);
    }

    /**
     * {@inheritDoc}
     */
    public function register(Container $app)
    {
        $this->setConfiguration($app);
    }

    /**
     * Injects the app configuration to the container. 
     *
     * @param  Container $app
     *
     * @return void
     */
    private function setConfiguration(Container $app) : void
    {
        $globalConfig = self::getConfig("config_{$app['env']}.yml");
        $serviceConfig = [
            'service' => self::getConfig('service.yml'),
        ];
        $controllerConfig = [
            'controller' => self::getConfig('controller.yml'),
        ];
        $controllerProviderConfig = [
            'controller_provider' => self::getConfig('controller_provider.yml'),
        ];

        $app['config'] = array_merge(
            $globalConfig,
            $serviceConfig,
            $controllerConfig,
            $controllerProviderConfig
        );
    }

    /**
     * Loads into the container configurations of a specific given file.
     *
     * @param  string $filename
     *
     * @return array
     */
    public static function getConfig(string $filename) : array
    {
        $container = new ContainerBuilder();
        $loader = new DIYamlFileLoader(
            $container,
            self::$locator
        );

        $loader->load($filename);
        $container->compile(true);

        return $container->getParameterBag()->all();
    }
}
