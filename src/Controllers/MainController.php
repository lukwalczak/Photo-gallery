<?php
declare(strict_types=1);

namespace Controllers;

use Core\View;

class MainController
{
    private $params;

    public function index()
    {
        echo View::render('index');
    }

    public static function pageNotFound()
    {
        echo View::render("Errors/pageNotFound");
    }
}