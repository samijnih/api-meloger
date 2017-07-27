<?php

namespace Providers;

use Kurl\Silex\Provider\DoctrineMigrationsProvider;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Silex\Provider\DoctrineServiceProvider;

/**
 * The database provider.
 */
class DatabaseProvider implements ServiceProviderInterface
{
    /**
     * {@inheritDoc}
     */
    public function register(Container $app)
    {
        $app->register(new DoctrineServiceProvider(), [
            'db.options' => [
                'driver' => $app['config']['database_driver'],
                'host' => $app['config']['database_host'],
                'port' => $app['config']['database_port'],
                'dbname' => $app['config']['database_name'],
                'user' => $app['config']['database_user'],
                'password' => $app['config']['database_password'],
                'charset' => $app['config']['database_charset'],
            ],
        ]);
        $app->register(
            new DoctrineMigrationsProvider(),
            [
                'migrations.directory' => $app['config']['doctrine']['migrations']['directory'],
                'migrations.name' => $app['config']['doctrine']['migrations']['name'],
                'migrations.namespace' => $app['config']['doctrine']['migrations']['namespace'],
                'migrations.table_name' => $app['config']['doctrine']['migrations']['table_name'],
            ]
        );
    }
}
