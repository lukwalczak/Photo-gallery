<?php
declare(strict_types=1);

namespace Controllers;

abstract class AbstractController
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

    public function model($model)
    {
        require_once dirname(__DIR__) . "/Models/" . $model . ".php";
        $model = "Models\\$model";
        $modelObj = new $model();
        return $modelObj;
    }

    public function view($view, $data = [])
    {
        require_once dirname(__DIR__) . "/Views/" . $view . "View.php";
    }

}