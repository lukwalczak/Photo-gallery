<?php
declare(strict_types=1);

namespace Controllers;

use Core\View;

class ImagesController
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
        View::render("default", $this->getParams());
    }

    public function add()
    {
        View::render("add", $this->getParams());
    }
}