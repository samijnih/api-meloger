<?php

namespace Services\Selenium;

use Assert\Assertion;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\WebDriverBy;

class SeLogerService
{
    /**
     * @var RemoteWebDriver
     */
    private $driver;

    /**
     * @var array
     */
    private $config;


    /**
     * Constructor.
     *
     * @param  RemoteWebDriver $driver
     * @param  array           $config
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(RemoteWebDriver $driver, array $config)
    {
        Assertion::notEmptyKey($config, 'service');
        Assertion::notEmptyKey($config, 'selenium');
        Assertion::notEmptyKey($config['service'], 'host');
        Assertion::notEmptyKey($config['selenium'], 'screenshot_path');

        $this->driver = $driver;
        $this->config = $config;
    }

    /**
     * Returns the host.
     *
     * @return string
     */
    public function getHost() : string
    {
        return $this->config['service']['host'];
    }

    /**
     * Logins the user through Se Loger.
     *
     * @param  string $email
     * @param  string $password
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     */
    public function login(string $email, string $password) : void
    {
        Assertion::email($email);

        $this->driver->get($this->getHost());

        // First click on `Mes favoris (0)` located on top-right.
        $this->driver->findElement(WebDriverBy::id('moduleEspacePerso'))
            ->click();
        // Wait until the menu to be opening with the `Connectez-vous` button,
        // under `Créez votre compte`.
        $this->driver->wait()->until(
            WebDriverExpectedCondition::presenceOfElementLocated(
                WebDriverBy::xpath('//*[@id="persoApp"]/div[2]/div/div/div/form/button[2]')
            )
        );

        // Click on the `Connectez-vous` button under `Créez votre compte`.
        $this->driver->findElement(WebDriverBy::xpath('//*[@id="persoApp"]/div[2]/div/div/div/form/button[2]'))
            ->click();
        // Wait until the displaying of the `Connectez-vous` button,
        // bellow the email and password inputs.
        $this->driver->wait()->until(
            WebDriverExpectedCondition::presenceOfElementLocated(
                WebDriverBy::xpath('//*[@id="persoApp"]/div[2]/div/div/div/form/button[1]')
            )
        );

        // Send the given email to the corresponding input.
        $this->driver->findElement(WebDriverBy::xpath('//*[@id="connectMail"]'))
            ->sendKeys($email);
        // Send the given password to the corresponding input.
        $this->driver->findElement(WebDriverBy::xpath('//*[@id="ep-pass-connect"]'))
            ->sendKeys($password);

        // Finally submit the login form.
        $this->driver->findElement(WebDriverBy::xpath('//*[@id="persoApp"]/div[2]/div/div/div/form/button[1]'))
            ->click();
        // Wait until the rendering of the user email in the header block..
        // At this point, it ensures a successful login!
        $this->driver->wait()->until(
            WebDriverExpectedCondition::presenceOfElementLocated(
                WebDriverBy::xpath('//*[@id="persoApp"]/div[1]/div/div/div/div[2]/div[1]')
            )
        );

        // Second click on `Mes favoris` located on top-right.
        $this->driver->findElement(WebDriverBy::id('moduleEspacePerso'))->click();
        // Wait until the current authenticated user email matches the given email,
        // on the header block.
        $this->driver->wait()->until(
            WebDriverExpectedCondition::textToBePresentInElement(
                WebDriverBy::xpath('//*[@id="persoApp"]/div[1]/div/div/div/div[2]/div[1]'),
                $email
            )
        );

        $this->screenshot();
        $this->quit();
    }

    /**
     * Takes a screenshot.
     *
     * @return void
     */
    public function screenshot() : void
    {
        $pictureName = date('h:i:s').'.png';

        $this->driver->takeScreenshot(
            $this->config['selenium']['screenshot_path'].$pictureName
        );
    }

    /**
     * Quits the current driver.
     *
     * @return void
     */
    public function quit() : void
    {
        $this->driver->quit();
    }
}
