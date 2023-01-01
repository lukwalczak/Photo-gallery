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
        session_start();
        $this->router->dispatch($_SERVER["REQUEST_URI"]);
    }

}