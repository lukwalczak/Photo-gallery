<?php
require(dirname(__DIR__) . '/Core/Router.php');
$router = Router::getInstance();
$url = $_SERVER['QUERY_STRING'];
$router->dispatch($url);
