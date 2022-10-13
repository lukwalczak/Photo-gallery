<?php
require (dirname(__DIR__).'/Core/Router.php');
$router = Router::getInstance();
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
echo '<pre>';
var_dump($router->getParameters());
echo '</pre>';

$router2 = Router::getInstance();

if ($router === $router2){
    echo "sa takie same";
}