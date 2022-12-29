<?php
declare(strict_types=1);
spl_autoload_register(function ($class) {
    $rootFolder = dirname(__DIR__) . '/src';
    $file = $rootFolder . '/' . str_replace('\\', '/', $class) . '.php';
    if (is_readable($file)) {
        require $rootFolder . '/' . str_replace('\\', '/', $class) . '.php';
    }
});
define('CSS_PATH', 'http://localhost/public/css/');
$app = new \Core\App();
$app->startApp();