<?php

namespace Services\Selenium;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;

abstract class SeleniumService
{
    /**
     * Returns a new instance of RemoteWebDriver.
     *
     * @param  string $host
     *
     * @return RemoteWebDriver
     */
    public static function createRemoteWebDriver(string $host) : RemoteWebDriver
    {
        $desiredCapabilities = DesiredCapabilities::chrome();

        $desiredCapabilities->setCapability('javascriptEnabled', true);
        $desiredCapabilities->setCapability('cssSelectorsEnabled', true);
        $desiredCapabilities->setCapability('browserConnectionEnabled', true);
        $desiredCapabilities->setCapability('locationContextEnabled', true);
        $desiredCapabilities->setCapability('databaseEnabled', true);

        return RemoteWebDriver::create($host, $desiredCapabilities);
    }
}
