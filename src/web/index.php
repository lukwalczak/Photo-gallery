<?php
require(dirname(__DIR__) . '/Core/Router.php');
$router = Router::getInstance();
$url = $_SERVER['QUERY_STRING'];
//if ($router->matchURL($url))
//{
//    echo "witam w ".$router->getCurrentPath();
//}
//else
//{
//    echo "nie odnaleziono strony  /$url :(";
//}
$router->dispatch($url);
