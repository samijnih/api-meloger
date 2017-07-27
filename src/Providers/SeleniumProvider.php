<?php

namespace Providers;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Services\Selenium\SeleniumService;
use Services\Selenium\SeLogerService;

/**
 * The selenium provider.
 */
class SeleniumProvider implements ServiceProviderInterface
{
    /**
     * @var \Facebook\WebDriver\Remote\RemoteWebDriver
     */
    private $driver;


    /**
     * {@inheritDoc}
     */
    public function register(Container $app)
    {
        $this->driver = (function () use ($app) {
            static $driver = null;

            if (null === $driver) {
                $driver = SeleniumService::createRemoteWebDriver($app['config']['selenium']['url']);
            }

            return $driver;
        })();

        $app['selenium.seloger'] = new SeLogerService($this->driver, [
            'selenium' => $app['config']['selenium'],
            'service' => $app['config']['service']['seloger'],
        ]);
        $app['selenium.driver'] = $this->driver;
    }

    /**
     * Quits the selenium driver.
     */
    public function __destruct()
    {
        if (null !== $this->driver->getCommandExecutor()) {
            $this->driver->quit();
        }
    }
}
