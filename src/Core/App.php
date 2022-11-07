<?php

namespace Core;

class App
{
    private $router;
    private $db;

    public function __construct()
    {
        $this->router = Router::getInstance();
    }

    public function startApp()
    {
        $this->router->dispatch($_SERVER["QUERY_STRING"]);
    }

}