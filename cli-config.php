<?php

use Doctrine\DBAL\Tools\Console\ConsoleRunner;

require_once __DIR__.'/vendor/autoload.php';

putenv('PROJECT_PATH=/var/www/api');

$app = require_once __DIR__.'/app/bootstrap.php';

return ConsoleRunner::createHelperSet($app['db']);