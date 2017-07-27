<?php

use Silex\WebTestCase;

class controllersTest extends WebTestCase
{
    public function testCannotAccessRoot()
    {
        $client = $this->createClient();
        $client->followRedirects(true);
        $crawler = $client->request('GET', '/');

        $this->assertFalse($client->getResponse()->isOk());
    }

    public function createApplication()
    {
        $app = require_once __DIR__.'/../app/bootstrap.php';
        $app['session.test'] = true;

        return $this->app = $app;
    }
}
