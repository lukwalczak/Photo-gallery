<?php
declare(strict_types=1);

namespace Controllers;

use Core\View;

class MainController
{
    private $params;

    public function __construct($passedParameters = [])
    {
        $this->params = $passedParameters;
    }

    public function getParams()
    {
        return $this->params;
    }

    public function setParams($params): void
    {
        $this->params = $params;
    }

    public function default()
    {
        echo View::render('index');
    }

    public static function pageNotFound()
    {
        echo View::render("Errors/pageNotFound");
    }
}