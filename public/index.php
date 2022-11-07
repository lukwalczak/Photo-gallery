<?php
declare(strict_types=1);
spl_autoload_register(function ($class) {
    $rootFolder = dirname(__DIR__) . '/src';
    $file = $rootFolder . '/' . str_replace('\\', '/', $class) . '.php';
    if (is_readable($file)) {
        require $rootFolder . '/' . str_replace('\\', '/', $class) . '.php';
    }
});

$app = new \Core\App();
$app->startApp();