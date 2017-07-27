<?php

use Dotenv\Dotenv;
use Providers\{
    AppProvider,
    CacheProvider,
    DatabaseProvider,
    DevProvider,
    RouterProvider,
    SeleniumProvider,
    YamlConfigProvider
};
use Silex\Application;

$projectPath = getenv('PROJECT_PATH');

$dotenv = new Dotenv($projectPath);
$dotenv->load();

$app = new Application([
    'env' => getenv('APP_ENV'),
    'project_path' => $projectPath,
    'app_dir' => getenv('APP_DIR'),
    'config_dir' => getenv('CONFIG_DIR'),
]);

$app->register(new YamlConfigProvider([$app['project_path'].'/'.$app['config_dir']]));
$app->register(new AppProvider());
$app->register(new DevProvider());
$app->register(new CacheProvider());
$app->register(new DatabaseProvider());
$app->register(new RouterProvider());
$app->register(new SeleniumProvider());

return $app;
