<?php
require dirname(__DIR__).'/Core/Router.php';
$router = new Router();
$router->setRouteTable();
$url = $_SERVER['QUERY_STRING'];
if ($router->matchURL($url))
{
    echo "witam w ".$router->getCurrentPath();
}
else
{
    echo "nie odnaleziono strony  /$url :(";
}
