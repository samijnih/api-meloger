<?php

namespace Providers;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Predis\Silex\ClientServiceProvider as PredisClient;

/**
 * The cache provider.
 */
class CacheProvider implements ServiceProviderInterface
{
    /**
     * {@inheritDoc}
     */
    public function register(Container $app)
    {
        $app->register(new PredisClient(), [
            'predis.parameters' => $app['config']['redis_tcp'],
        ]);
    }
}
