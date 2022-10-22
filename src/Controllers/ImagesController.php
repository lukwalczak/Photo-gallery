<?php
declare(strict_types=1);

namespace Controllers;

use Core\View;

class ImagesController
{
    private $params;

    private $viewPath = "Images/";

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

    public function index()
    {
        echo View::render($this->viewPath . "index", $this->getParams());
    }

    public function add()
    {
        echo View::render($this->viewPath . "add", $this->getParams());
    }
}