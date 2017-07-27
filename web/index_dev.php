<?php

declare(strict_types = 1);

$allowedIpAddresses = [
    '127.0.0.1',
    'fe80::1',
    '::1',
    '192.168.99.101',
    '92.128.115.46',
    '192.168.99.1',
];

// This check prevents access to debug front controllers that are deployed by accident to production servers.
// Feel free to remove this, extend it, or make something more sophisticated.
if (!in_array(@$_SERVER['REMOTE_ADDR'], $allowedIpAddresses)) {
    header('HTTP/1.0 403 Forbidden');
    exit('You are not allowed to access this file. Check '.basename(__FILE__).' for more information.');
}

require_once __DIR__.'/../vendor/autoload.php';

putenv('APP_ENV=dev');
Symfony\Component\Debug\Debug::enable();

$app = require_once __DIR__.'/../app/bootstrap.php';
$app->run();
