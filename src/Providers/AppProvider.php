<?php

namespace Providers;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Silex\Provider\AssetServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\TwigServiceProvider;

/**
 * The application provider.
 */
class AppProvider implements ServiceProviderInterface
{
    /**
     * {@inheritDoc}
     */
    public function register(Container $app)
    {
        $app->register(new ServiceControllerServiceProvider());
        $app->register(new AssetServiceProvider());
        $app->register(new TwigServiceProvider(), [
            'cache' => $app['config']['twig_cache_path'],
            'twig.path' => $app['config']['twig_path'],
        ]);
        $app->register(new HttpFragmentServiceProvider());

        $app['twig'] = $app->extend('twig', function ($twig, $app) {
            return $twig;
        });
    }
}
