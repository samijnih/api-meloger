<?php

namespace Providers;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\WebProfilerServiceProvider;

/**
 * The development provider.
 */
class DevProvider implements ServiceProviderInterface
{
    /**
     * {@inheritDoc}
     */
    public function register(Container $app)
    {
        if ($app['env'] !== 'prod') {
            $app->register(new MonologServiceProvider(), array(
                'monolog.logfile' => $app['config']['monolog']['logfile'],
                'monolog.level' => $app['config']['monolog']['level'],
            ));

            $app->register(new WebProfilerServiceProvider(), array(
                'profiler.cache_dir' => $app['config']['profiler']['cache_dir'],
            ));
        }
    }
}
