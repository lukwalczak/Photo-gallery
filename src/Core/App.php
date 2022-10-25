<?php

namespace Core;

class App
{
    public function __construct()
    {

    }

    public static function startApp()
    {
        AutoLoader::autoload();
        $router = Router::getInstance();
        $router->dispatch($_SERVER["QUERY_STRING"]);
    }

}