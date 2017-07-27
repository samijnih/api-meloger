<?php

namespace Providers;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * The router provider.
 */
class RouterProvider implements ServiceProviderInterface
{
    /**
     * {@inheritDoc}
     */
    public function register(Container $app)
    {
        $app->mount('me', new $app['config']['controller_provider']['user.class']);

        $app->error($this->getFallbackResponse($app));
    }

    /**
     * Returns the error response.
     *
     * @param  Container $app
     *
     * @return \Closure
     */
    public function getFallbackResponse(Container $app) : \Closure
    {
        return function (\Exception $e, Request $request, $code) use ($app) {
            if ($app['debug']) {
                return;
            }

            // 404.html, or 40x.html, or 4xx.html, or error.html
            $templates = array(
                'errors/'.$code.'.html.twig',
                'errors/'.substr($code, 0, 2).'x.html.twig',
                'errors/'.substr($code, 0, 1).'xx.html.twig',
                'errors/default.html.twig',
            );

            return new Response(
                $app['twig']
                    ->resolveTemplate($templates)
                    ->render(['code' => $code]), $code
            );
        };
    }
}
