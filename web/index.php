<?php

declare(strict_types = 1);

ini_set('display_errors', '0');

require_once __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../app/bootstrap.php';
$app->run();
