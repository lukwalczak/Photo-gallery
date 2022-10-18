<?php
require(dirname(__DIR__) . '/core/Router.php');
$router = Router::getInstance();
$url = $_SERVER['QUERY_STRING'];
$router->dispatch($url);
