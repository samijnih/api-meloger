<?php

namespace Providers\Controllers;

use Controllers\UserController;
use Silex\Application;
use Silex\Api\ControllerProviderInterface;

/**
 * The user controller provider.
 */
class UserControllerProvider implements ControllerProviderInterface
{
    /**
     * {@inheritDoc}
     */
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $app['controller.user'] = function() use ($app) {
            return new $app['config']['controller']['user.class']($app['selenium.seloger']);
        };

        $controllers->get('index-data', 'controller.user:indexData');

        return $controllers;
    }
}
